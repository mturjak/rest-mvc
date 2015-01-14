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

        if(!empty($post->username)) {
            $message .= " Welcome {$post->username}!";
        } else {
            $message = '';
        }
        
        // render JSON response if in API else redirect
        if($this->response_type == 'api'){
            $this->render('json',array(
                'message' => $message
            ));
        } else {
            $this->render('index/index');
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
}