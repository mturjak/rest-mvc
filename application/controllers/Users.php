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
  
}