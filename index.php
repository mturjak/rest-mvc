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

// The Composer auto-loader (will be used as default internal autoloader if exists)
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    require 'application/config/autoload.php';
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

// add custom request
$app->container->singleton('request', function ($c) {
    return new Request($c['environment']);
});

// initialize routing
new Router();

// run Slim
$app->run();
