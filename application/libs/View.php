<?php

/**
 * Class View
 *
 * Provides the methods all views will have
 */
class View extends Slim\View
{
    public function __construct()
    {
        debug(__FILE__, 'view instantiated');
        parent::__construct();


        $this->appendData(array(
            'render_without_header_and_footer' => false,
            'error' => false,
            'message' => 'No message.'
        ));
    }

    public function render($template, $data = null)
    {
        /*if ($this->render_without_header_and_footer == true) {
            require VIEWS_PATH . $template . '.php';
        } else {
            require VIEWS_PATH . '_templates/header.php';
            require VIEWS_PATH . $template . '.php';
            require VIEWS_PATH . '_templates/footer.php';
        }*/

        debug(__FILE__, 'view render');
        if(DEBUG_MODE) {
            $app = Slim\Slim::getInstance();
            $this->appendData(array(
                'debugger' => array(
                    'request' => $app->request->response_str,
                    'response_code' => $app->response->getStatus(),
                    'app_lifecycle' => $app->debugger
                )
            ));
        }

        if($this->get('render_without_header_and_footer')) {
            echo parent::render($template, $this->all());
        } else {
            echo parent::render('_templates/header');
            echo parent::render($template);
            echo parent::render('_templates/footer');
        }
    }

    /**
     * simply includes (=shows) the view. this is done from the controller. In the controller, you usually say
     * $this->view->render('help/index'); to show (in this example) the view index.php in the folder help.
     * Usually the Class and the method are the same like the view, but sometimes you need to show different views.
     * @param string $filename Path of the to-be-rendered view, usually folder/file(.php)
     * @param boolean $render_without_header_and_footer Optional: Set this to true if you don't want to include header and footer
     *
    public function render($template, $data = null)
    {
        if ($this->render_without_header_and_footer == true) {
            require VIEWS_PATH . $template . '.php';
        } else {
            require VIEWS_PATH . '_templates/header.php';
            require VIEWS_PATH . $template . '.php';
            require VIEWS_PATH . '_templates/footer.php';
        }
        $silent = array('flash');
        return json_encode(array_diff_key($this->all(), array_flip($silent)));
    }*/

    /**
     * renders the feedback messages into the view
     */
    public function renderFeedbackMessages()
    {
        // echo out the feedback messages (errors and success messages etc.),
        // they are in $_SESSION["feedback_positive"] and $_SESSION["feedback_negative"]
        require VIEWS_PATH . '_templates/feedback.php';

        // delete these messages (as they are not needed anymore and we want to avoid to show them twice
        Session::set('feedback_positive', null);
        Session::set('feedback_negative', null);
    }

    /**
     * Checks if the passed string is the currently active controller.
     * Useful for handling the navigation's active/non-active link.
     * @param string $filename
     * @param string $navigation_controller
     * @return bool Shows if the controller is used or not
     */
    protected function isActiveController($navigation_controller)
    {
        $active = $this->get('mvc');

        if ($active->controller == $navigation_controller) {
            return true;
        }
        // default return
        return false;
    }

    /**
     * Checks if the passed string is the currently active controller-action (=method).
     * Useful for handling the navigation's active/non-active link.
     * @param string $navigation_action
     * @return bool Shows if the action/method is used or not
     */
    protected function isActiveAction($navigation_action)
    {
        $active = $this->get('mvc');

        if ($active->action == $navigation_action) {
            return true;
        }
        // default return of not true
        return false;
    }

    /**
     * Checks if the passed string is the currently active controller and controller-action.
     * Useful for handling the navigation's active/non-active link.
     * @param string $navigation_controller_and_action
     * @return bool
     */
    protected function isActiveControllerAndAction($navigation_controller_and_action)
    {
        $active = $this->get('mvc');

        $split_filename = explode("/", $navigation_controller_and_action);
        $navigation_controller = $split_filename[0];
        $navigation_action = $split_filename[1];

        if ($active->controller == $navigation_controller AND $active->action == $navigation_action) {
            return true;
        }
        // default return of not true
        return false;
    }

    /********** Slim *************/


    /**
     * Overrides the Slim\View method to add the .php file extension
     * @param string $template file path without extension (e.g. 'json' or 'user/login')
     */
    public function getTemplatePathname($template)
    {
        return $this->templatesDirectory . DIRECTORY_SEPARATOR . ltrim($template, DIRECTORY_SEPARATOR) . ".php";
    }
}
