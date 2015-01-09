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
      $content_type = explode(';', $this->getContentType(), 2);

      switch(1) {
        case ($res_uri[0] === 'api'):
          $this->env['PATH_INFO'] = '/' . (isset($res_uri[1]) ? $res_uri[1] : '');
        case (trim($content_type[0]) === 'application/json' || $this->isAjax()):
          $this->response_type = 'api';
          break;
      }

      if($this->get('where') !== null) {
        $q = $this->get('where');
        $q = urldecode($q);
        $q = json_decode($q);
      }
      // TODO: other query operations, like order (see parse.com for ideas)

      $this->response_str = " [method: {$this->getMethod()}] [url: {$this->getResourceUri()}] [type: {$this->responseType()}]";
    }

    /**
     * Getter method for the $response_type variable
     */
    public function responseType() {
      return $this->response_type;
    }
}