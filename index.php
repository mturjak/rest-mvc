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
$app = new Slim\Slim(
// TODO: move to config
array(
    'log.enabled' => true
));
// initialize custom request
$app->request = new Request($app->environment);
// initialize routing
$router = new Router();
// run Slim
$app->run();