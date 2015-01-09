<?php

/**
 * Class Error
 * This controller simply shows a page that will be displayed when a controller/method is not found.
 * Simple 404 handling.
 */
class Error extends Controller
{
    /**
     * Construct this object by extending the basic Controller class
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * This method controls what happens / what the user sees when an error happens (404)
     */
    function throw_err($code)
    {
        // TODO: dynamicaly load message according to $code
        $response["error"] = true;
        $response["message"] = "Resource not found on server.";

        $this->echoRespnse($code, $response);

        //$this->view->render('error/'.$code);
    }
}
