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
        $app = $this->app;
        $req = $app->request();

        if($app->response_type === 'api' && $req->isPost()) {
            $body = json_decode($req->getBody());

            // checks if valid json format
            if(json_last_error() === JSON_ERROR_NONE) {
              $env = $app->environment();
              $env['slim.request.form_hash'] = (array)$body;

              // continue
              $this->next->call();
            } else {
              $error = (object)array(
                  'error' => true,
                  'message' => 'Error in submited data! Not valid JSON format.'
              );
              $app->contentType('application/json');
              $app->response->setStatus(400);
              $app->response->setBody(json_encode($error));
            }
        }
    }
}