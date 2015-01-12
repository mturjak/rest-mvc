<?php
/**
 * Class Error
 * This controller simply shows a page that will be displayed when a controller/method is not found.
 * Simple 404 handling.
 */
class Error extends Controller
{
    /**
     * This method controls what happens / what the user sees when an error happens (404)
     */
    function notFound()
    {
        $response["error"] = true;
        $response["message"] = "Resource not found on server.";

        $this->render('error', $response, 404);
    }

    /**
     * This method controls what happens / what the user sees when an error happens (404)
     */
    function genericError($message, $code)
    {
        $response["error"] = true;
        $response["message"] = $message;

        $this->render('error', $response, $code);
    }
}
