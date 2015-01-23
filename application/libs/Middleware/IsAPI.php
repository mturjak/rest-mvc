<?php
/**
 * IsAPI
 * Checks if the request is through the API or for the html page
 */
namespace Middleware;

class IsAPI extends \Slim\Middleware
{
    /**
     * Call
     */
    public function call()
    {
        $app = $this->app;
        $req = $app->request();
        $env = $app->environment();

        $res_uri = explode('/', $req->get('url'), 2);
        $media_type = trim($req->getMediaType());

        switch(1) {
          case ($res_uri[0] === 'api'):
            $env['PATH_INFO'] = '/' . (isset($res_uri[1]) ? $res_uri[1] : '');
          case ($media_type === 'application/json' || $req->isAjax()):
            $app->contentType('application/json');
            $app->response_type = 'api';
            break;
          default:
            $app->response_type = 'html';
            // using native PHP sessions on html page
            \Session::init();
            break;
        }

        // request info for debugging purposes
        $app->req_str = "[method: {$req->getMethod()}] [url: {$req->getResourceUri()}] [type: {$app->response_type}]";
        $this->next->call();
    }
}