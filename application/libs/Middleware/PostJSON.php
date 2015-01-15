<?php
/**
 * PostJSON
 * Extracts post variables from JSON encoded request body
 */
namespace Middleware;

class PostJson extends \Slim\Middleware
{
    /**
     * Call
     */
    public function call()
    {
        if($this->app->response_type === 'api' && $this->isPost()) {
            $body = json_decode($this->app->request()->getBody());

            // checks if valid json format
            if(json_last_error() === JSON_ERROR_NONE) {
              $env = $this->app->environment();
              $env['slim.request.form_hash'] = (array)$body;
            } else {
              $error = (object)array(
                  'error' => true,
                  'message' => 'Error in submited data! Not valid JSON format.'
              );
              $app->response->setStatus(400);
              // we have to setBody explicitely
              echo(json_encode($error));
            }
        }
    }
}