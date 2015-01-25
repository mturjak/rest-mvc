<?php
/**
 * Routes (html)
 * Slim route deffinitions (mapping: API request -> controller/action)
 * required inside custom Router class ($this <=> Router instance)
 *
 */


/* html rautes */

$app->get('(/$|/index$|$)', function () {
    $this->loadController();
});

$app->get('/login(/$|/index$|$)', function () {
    $this->loadController('users', 'loginPage');
});

$app->get('/loginwithcookie(/$|/index$|$)', function () {
    $this->loadController('users', 'loginWithCookie');
});

$app->get('/overview(/$|/index$|$)', 'Middleware\Auth::authSession', function () {
    $this->loadController();
});

$app->get('/register(/$|/index$|$)', function () {
    $this->loadController('users', 'registerPage');
});

$app->get('/captcha(/$|/index$|$)', function () {
    $this->loadController('users', 'showCaptcha');
});