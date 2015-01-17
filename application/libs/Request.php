<?php
/**
 * Class Request
 * Extending Slim's Request class
 */

class Request extends Slim\Http\Request
{
    public $response_str;

    /** @var null The controller part of the URL */
    private $url_controller;

    public function __construct($env)
    {
      parent::__construct($env);
      $app = Slim\Slim::getInstance();

      $res_uri = explode('/', $this->get('url'), 2);
      $media_type = trim($this->getMediaType());

      /*switch(1) {
        case ($res_uri[0] === 'api'):
          $this->env['PATH_INFO'] = '/' . (isset($res_uri[1]) ? $res_uri[1] : '');
        case ($media_type === 'application/json' || $this->isAjax()):
          $app->response_type = 'api';
          break;
        default:
          $app->response_type = 'html';
          break;
      }*/

      /*if($this->get('where') !== null) {
        $q = $this->get('where');
        $q = urldecode($q);
        $q = json_decode($q);
      }*/
      // TODO: other query operations, like order (see parse.com for ideas)
    }
}