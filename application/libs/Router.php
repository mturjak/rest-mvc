<?php
/* Router class */
class Router
{

    private $classes = 'classes';
    private $users = 'users';

    public function __construct()
    {
        $this->setRoutes();
    }

    private function setRoutes()
    {
        $app = Slim\Slim::getInstance();

        /* API rautes */


        /************* classes group **************/

        $app->group('/' . $this->classes, function() use($app) {


            /**************  GET  ***************/

            /**
             * List classes
             */
            $app->get('(/$|/index$|$)', 'Auth::authBase', function () use($app) {
                $this->loadController($this->classes, 'index');
            });

            /**
             * List records
             */
            $app->get('/(:name)(/$|/index$|$)', 'Auth::authBase', function ($name) use($app) {
                  if($name === 'index') {
                      $app->redirect(URL . $this->classes . '/');
                  }
                  $this->loadController($this->classes, 'list', $name);
            });

            /**
             * Show record
             */
            $app->get('/:name/:id(/$|/index(/|$)|$)', 'Auth::authBase', function ($name,$id) use($app) {
                if($name === 'index' || $id === 'index') {
                    $app->redirect(URL . $this->classes . '/');
                }
                $this->loadController($this->classes, 'show', $name, $id);
            });


            /**************  POST  ***************/

            /**
             * Create object / create class if not exists
             */
            $app->post('/(:name)(/$|/index$|$)', 'Auth::authMember', function ($name) use($app) {
                  if($name === 'index' || $name === '') {
                      $app->notFound();
                  } else {
                      $this->loadController($this->classes, 'add', $name);
                  }
            });

            /**************  PUT  ***************/

            /**
             * Update record
             */
            $app->put('/:name/:id(/$|/index(/|$)|$)', 'Auth::authMember', function ($name,$id) use($app) {
                if($name === 'index' || $id === 'index') {
                    $app->redirect(URL . $this->classes . '/');
                }
                $this->loadController($this->classes, 'edit', $name, $id);
            });

            /**************  DELETE  ***************/

            /**
             * Delete record
             */
            $app->delete('/:name/:id(/$|/index(/|$)|$)', 'Auth::authMember', function ($name,$id) use($app) {
                if($name === 'index' || $id === 'index') {
                  $app->halt(105, 'Problem deleting!');
                }
                $this->loadController($this->classes, 'delete', $name, $id);
            });
        }); /*** slasses group END ***/

        /************* users group **************/

        $app->group('/' . $this->users, function() use($app) {


            /**************  GET  ***************/

            /**
             * List users
             */
            $app->get('(/$|/index$|$)', 'Auth::authMember', function () use($app) {
                  $this->loadController($this->users, 'list');
            });

            /**
             * Show user
             */
            $app->get('/:id(/$|/index(/|$)|$)', 'Auth::authMember', function ($id) use($app) {
                if($id === 'index') {
                    $app->redirect(URL . $this->users . '/');
                }
                $this->loadController($this->users, 'show', $id);
            });


            /**************  POST  ***************/

            /**
             * Create user / Sign in
             */
            $app->post('(/$|/index$|$)', 'Auth::authSession', function () use($app) {
                $this->loadController($this->users, 'add');
            });

            /**************  PUT  ***************/

            /**
             * Update record
             */
            $app->put('/:id(/$|/index(/|$)|$)', 'Auth::authSession', function ($id) use($app) {
                if($id === 'index') {
                    $app->redirect(URL . $this->users . '/');
                }
                $this->loadController($this->users, 'edit', $id);
            });

            /**************  DELETE  ***************/

            /**
             * Delete record
             */
            $app->delete('/:id(/$|/index(/|$)|$)', 'Auth::authSession', function ($id) use($app) {
                if($id === 'index') {
                  $app->halt(105, 'Problem deleting: id not set!');
                }
                $this->loadController($this->users, 'delete', $id);
            });
        }); /*** users group END ***/

        /**************** users related rules *********/

        $app->post('/login(/$|/index$|$)', 'Auth::authBase', function () use($app) {
                $this->loadController($this->users, 'login');
        });

        $app->post('/requestPasswordReset(/$|/index$|$)', 'Auth::authBase', function () use($app) {
                $this->loadController($this->users, 'requestPasswordReset');
        });

        $app->post('/verify(/$|/index$|$)', 'Auth::verifyCode', function () use($app) {
                $this->loadController($this->users, 'verify');
        });

        /****************  errors  *****************/

        /**
         * 404 - Not Found
         */
        $app->notFound(function() use($app) {
            $response["error"] = true;
            $response["message"] = "Resource not found on server." . (DEBUG_MODE ? $app->request->response_str : '');
            $this->echoRespnse(404, $response);
        });

        // TODO: set other errors
    }

    /**
     * Load controller and call controller method
     */
    private function loadController($controller = null, $action = null, $param1 = null, $param2 = null)
    {
        if(isset($controller)) {
            $controller = ucfirst($controller);
            $controller = new $controller();
            if (isset($action)) {
                if (method_exists($controller, $action)) {
                    if (isset($param2)) {
                        $controller->{$action}($param1, $param2);
                    } elseif (isset($param1)) {
                        $controller->{$action}($param1);
                    } else {
                        // if no parameters given, just call the method without arguments
                        $controller->{$action}();
                    }
                } else {
                    // TODO: go to error page
                }
            } else {
                $controller->index();
            }
        } else {
            $controller = new Index();
            $controller->index();
        }
    }

    /* TODO: move to controller class */
    private function echoRespnse($status_code, $response) {
        $app = Slim\Slim::getInstance();
        // Http response code
        $app->response->setStatus($status_code);
     
        // setting response content type to json
        $app->contentType('application/json');
     
        echo json_encode($response);
    }
}