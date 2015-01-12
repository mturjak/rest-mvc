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
        $arg = (!isset($name) ? '' : " Action: {$name}");
        $this->render('user/login', array(
            'message' => "Test login response.{$arg}"
        ));
    }
}