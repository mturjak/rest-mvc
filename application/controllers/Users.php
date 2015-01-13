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

    public function login($name = null)
    {

        // render JSON response if in API else redirect
        if($this->response_type == 'api'){
            $arg = (!isset($name) ? '' : " Action: {$name}");
            $this->render('json', array(
                'message' => "Test login response.{$arg}"
            ));
        } else {
            // redirect
        }


    }

    /**************  Non-API speciffic methods *************/

    public function loginPage()
    {
        $arg = (!isset($name) ? '' : " Action: {$name}");
        $this->render('user/login', array(
            'message' => "Test login response.{$arg}"
        ));
    }
}