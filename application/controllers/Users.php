<?php
/* Users controller */
class Users extends Controller
{

    public function index()
    {

        // TODO: dynamicaly load message according to $code
        $response["error"] = false;
        $response["message"] = "Test response.";

        $this->echoRespnse(200, $response);
    }

    public function login($name = null)
    {

        // TODO: dynamicaly load message according to $code
        $response["error"] = false;
        $response["message"] = "Test login response. Action: " . $name;

        $this->echoRespnse(200, $response);
    }
  
}