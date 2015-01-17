<?php
/**
 * PostJSON
 * Extracts post variables from JSON encoded request body
 */
namespace Middleware;

class PostJSON extends \Slim\Middleware
{
    /**
     * Call
     */
    public function call()
    {
        $req = $this->app->request();

        if($this->app->response_type === 'api' && $req->isPost()) {
            $body = json_decode($req->getBody());

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

        $this->next->call();
    }
}