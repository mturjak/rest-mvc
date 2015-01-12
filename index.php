<?php

/**
 * A simple, clean and secure PHP Login Script embedded into a small framework.
 * Also available in other versions: one-file, minimal, advanced. See php-login.net for more info.
 *
 * MVC FRAMEWORK VERSION
 *
 * @author mturjak
 * @link http://newtpond.com/
 * @link https://github.com/mturjak/rest-api/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// Load application config (error reporting, database credentials etc.)
require 'application/config/config.php';

// The auto-loader to load the php-login related internal stuff automatically
require 'application/config/autoload.php';

// The Composer auto-loader (official way to load Composer contents) to load external stuff automatically
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// enable Kint outpud for debugging
Kint::enabled(DEBUG_MODE);

// Start our application
$app = new Slim\Slim(array(
    'view' => 'View',
    'request' => 'Request',
    'templates.path' => 'application/views',
    'mode' => 'production',
    'debug' => false
));

// define debugging capability (records messages during execution)
$app->debugger = array();
function debug($file, $str) {
    if(DEBUG_MODE) {
      $app = Slim\Slim::getInstance();
      $debugger = $app->debugger;
      array_push($debugger, $str . ' (' . str_replace(__DIR__ . '/', '', $file) . ')');
      $app->debugger = $debugger;
    }
    return true;
}

debug(__FILE__, 'app instantiated');

// initialize custom request
$app->container->singleton('request', function ($c) {
    return new Request($c['environment']);
});
//$app->request = new Request($app->environment);
debug(__FILE__, 'custom request class added');
// initialize routing
$router = new Router();
debug(__FILE__, 'router instantiated');
// run Slim
$app->run();