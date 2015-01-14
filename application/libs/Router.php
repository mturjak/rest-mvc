<?php
/* Router class */
class Router
{

    private $classes = 'classes';
    private $users = 'users';

    private $app;

    public function __construct()
    {
        $this->app = Slim\Slim::getInstance();
        $this->setAPIRoutes();

        if($this->app->request->responseType() !== 'api') {
            $this->setPageRoutes();
        }
        
    }

    private function setAPIRoutes()
    {
        $app = $this->app;

        /* API rautes */

        /************* classes group **************/

        $app->group('/' . $this->classes, function() use($app) {


            /**************  GET  ***************/

            /**
             * List classes
             */
            $app->get('(/$|/index$|$)', 'Middleware\Auth::authBase', function () {
                $this->loadController($this->classes, 'index');
            });

            /**
             * List records
             */
            $app->get('/(:name)(/$|/index$|$)', 'Middleware\Auth::authBase', function ($name) use($app) {
                  if($name === 'index') {
                      $app->redirect(URL . $this->classes . '/');
                  }
                  $this->loadController($this->classes, 'items', $name);
            });

            /**
             * Show record
             */
            $app->get('/:name/:id(/$|/index(/|$)|$)', 'Middleware\Auth::authBase', function ($name,$id) use($app) {
                if($name === 'index' || $id === 'index') {
                    $app->redirect(URL . $this->classes . '/');
                }
                $this->loadController($this->classes, 'show', $name, $id);
            });


            /**************  POST  ***************/

            /**
             * Create object / create class if not exists
             */
            $app->post('/(:name)(/$|/index$|$)', 'Middleware\Auth::authMember', function ($name) use($app) {
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
            $app->put('/:name/:id(/$|/index(/|$)|$)', 'Middleware\Auth::authMember', function ($name,$id) use($app) {
                if($name === 'index' || $id === 'index') {
                    $app->redirect(URL . $this->classes . '/');
                }
                $this->loadController($this->classes, 'edit', $name, $id);
            });

            /**************  DELETE  ***************/

            /**
             * Delete record
             */
            $app->delete('/:name/:id(/$|/index(/|$)|$)', 'Middleware\Auth::authMember', function ($name,$id) use($app) {
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
            $app->get('(/$|/index$|$)', 'Middleware\Auth::authMember', function () {
                  $this->loadController($this->users, 'index');
            });

            /**
             * Show user
             */
            $app->get('/:id(/$|/index(/|$)|$)', 'Middleware\Auth::authMember', function ($id) use($app) {
                if($id === 'index') {
                    $app->redirect(URL . $this->users . '/');
                }
                $this->loadController($this->users, 'show', $id);
            });


            /**************  POST  ***************/

            /**
             * Create user / Sign in
             */
            $app->post('(/$|/index$|$)', 'Middleware\Auth::authSession', function () {
                $this->loadController($this->users, 'add');
            });

            /**************  PUT  ***************/

            /**
             * Update record
             */
            $app->put('/:id(/$|/index(/|$)|$)', 'Middleware\Auth::authSession', function ($id) use($app) {
                if($id === 'index') {
                    $app->redirect(URL . $this->users . '/');
                }
                $this->loadController($this->users, 'edit', $id);
            });

            /**************  DELETE  ***************/

            /**
             * Delete record
             */
            $app->delete('/:id(/$|/index(/|$)|$)', 'Middleware\Auth::authSession', function ($id) use($app) {
                if($id === 'index') {
                  $app->halt(105, 'Problem deleting: id not set!');
                }
                $this->loadController($this->users, 'delete', $id);
            });
        }); /*** users group END ***/

        /**************** users related rules *********/

        $app->post('/login(/:name$|/index$|$)', 'Middleware\Auth::authBase', function ($name = null) {
            $this->loadController($this->users, 'login', $name);
        });

        $app->post('/requestPasswordReset(/$|/index$|$)', 'Middleware\Auth::authBase', function () {
            $this->loadController($this->users, 'requestPasswordReset');
        });

        $app->post('/verify(/$|/index$|$)', 'Middleware\Auth::verifyCode', function () {
            $this->loadController($this->users, 'verify');
        });

        /****************  errors  *****************/

        /**
         * 404 - Not Found
         */
        $app->notFound(function() {
            $this->loadController('error', 'notFound');
        });

        // for other errors
        $app->error(function(\Exception $e) {
            $this->loadController('error', 'genericError', $e->getMessage(), $e->getCode());
        });

        // error page
        $app->get('/error(/$|/index$|$)', function () {
            $this->loadController('error','genericError');
        });
    }

    /**
    * Sets routes speciffic to html pages
    */
    private function setPageRoutes()
    {
        $app = $this->app;

        $app->get('(/$|/index$|$)', function () {
              $this->loadController();
        });

        $app->get('/login(/$|/index$|$)', function () {
              $this->loadController($this->users, 'loginPage');
        });
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
}