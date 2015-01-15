<?php
/* Router class */
class Router
{

    private $app;

    public function __construct()
    {
        $this->app = Slim\Slim::getInstance();
        $this->setAPIRoutes();

        if($this->app->response_type !== 'api') {
            $this->setPageRoutes();
        }
        
    }

    private function setAPIRoutes()
    {
        $app = $this->app;
        require 'application/config/routes.php';
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
              $this->loadController('users', 'loginPage');
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