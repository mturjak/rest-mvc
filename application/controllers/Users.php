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

        if(!empty($username = $post->username) && !empty($password = $post->password)) {
            // call to model verify user & password
            // if user credentials ok
            $x = false;
            if($password == "test" && $username == "martin") {

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
            $this->app->flash('success', $message);
            if($code == 200) {
                Middleware\Session::set('user_logged_in', true);
                $this->app->redirect(); // TODO: redirect to point of origin
            } else {
                $this->app->redirect('login');
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
        \Middleware\Session::destroy();
        $this->render('index/index', array(
            'message' => "Logout successful. Session terminated."
        ));
    }
}