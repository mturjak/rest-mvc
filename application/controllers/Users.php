<?php
/* Users controller */
class Users extends Controller
{
    public function index()
    {
        $this->render('user/index', array(
            'message' => 'Test response.'
        ));
    }

    public function login()
    {
        $message = 'Login successful!';
        $post = (object)$this->app->request()->post();
        $code = 200;
        $sess_token = null;
        $sess_expires = 0;

        $login_model = $this->loadModel('Login');
        // perform the login method, put result (true or false) into $login_successful
        
        if(!empty($username = $post->username) && !empty($password = $post->password)) {
            // call to model verify user & password
            // if user credentials ok
            $login = $login_model->login();
            if($login !== false) {
                if($login !== true) {
                    $sess_token = $login;
                    $sess_expires = 30;
                }
            } else {
                $message = 'Sorry! Wrong credentials.';
                $code = 401;
            }
        } else {
            // return message if missing credentials
            $message = 'Username or password missing.';
            $code = 401;
        }

        // render JSON response if in API else redirect
        if($this->response_type == 'api'){
            $this->render('json',array(
                'session_token' => $sess_token,
                'session_expires' => $sess_expires,
                'message' => $message
            ), $code);
        } else {
            if($code == 200) {
                if(REDIRECT_BACK) {
                    $redirect = Session::get('redirect');
                }
                if(!empty($redirect)) {
                    Session::uset('redirect');
                } else {
                    $redirect = LOGIN_REDIRECT;
                }
                $this->app->redirect(URL . $redirect);
            } else {
                $this->app->redirect(URL . 'login');
            }
        }
    }

    /**************  Non-API speciffic methods *************/

    public function loginPage()
    {
        $arg = (!isset($name) ? '' : " Action: {$name}");
        $this->render('user/loginpage', array(
            'message' => "Test login response.{$arg}"
        ));
    }

    public function logout()
    {
        $login_model = $this->loadModel('Login');
        $logout = $login_model->logout();
        if($this->app->response_type == 'html') {
            $this->app->redirect(URL . LOGOUT_REDIRECT);
        } elseif($this->app->response_type == 'api') {
            $message = ($logout ? 'Logout successful!' : 'You were already logged out.');
            $this->render('json',array(
                'message' => $message
            ));
        }
    }
}