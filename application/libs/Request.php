<?php
/**
 * Class Request
 * Extending Slim's Request class
 */

class Request extends Slim\Http\Request
{
    /** @var 'html' Indicates whether the response should he a html page (html) or in json (api) */
    private $response_type = 'html';

    public $response_str;

    /** @var null The controller part of the URL */
    private $url_controller;

    public function __construct($env)
    {
      parent::__construct($env);

      $res_uri = explode('/', $this->get('url'), 2);
      $media_type = trim($this->getMediaType());

      switch(1) {
        case ($res_uri[0] === 'api'):
          $this->env['PATH_INFO'] = '/' . (isset($res_uri[1]) ? $res_uri[1] : '');
        case ($media_type === 'application/json' || $this->isAjax()):
          $this->response_type = 'api';
          break;
      }

      if($this->response_type === 'api' && $this->isPost()) {
        $body = json_decode($this->getBody());
        
        // checks if valid json format
        if(json_last_error() == JSON_ERROR_NONE) {
          $this->env['slim.request.form_hash'] = (array)$body;
        } else {
          $app = Slim\Slim::getInstance();
          $app->view->set('render_without_header_and_footer', true);
          header('Content-Type: application/json; charset=UTF-8');
          $app->render('json', array(
              'error' => true,
              'message' => 'Error in submited JSON data!'
            ),
            400
          );
          // force stop app
          die();
        }
      }

      if($this->get('where') !== null) {
        $q = $this->get('where');
        $q = urldecode($q);
        $q = json_decode($q);
      }
      // TODO: other query operations, like order (see parse.com for ideas)

      $this->response_str = "[method: {$this->getMethod()}] [url: {$this->getResourceUri()}] [type: {$this->responseType()}]";
    }

    /**
     * Getter method for the $response_type variable
     */
    public function responseType() {
      return $this->response_type;
    }
}