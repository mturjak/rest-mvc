<?php

/**
 * Classes controller
 * 
 */
class Classes extends Controller
{
    public function index()
    {
        //$this->app->flashNow('info', 'Your credit card is expired');

        $this->render('classes/index', array(
            'message' => 'List of accessable classes.'
        ));
    }

    public function items($name)
    {
        $this->render('classes/index', array(
            'message' => "List of objects of class \"{$name}\"."
        ));
        //$error = 'Always throw this error';
        //throw new Exception($error, 400);
    }

    public function show($name, $id)
    {
        $this->render('classes/view', array(
            'message' => "Single object of class \"{$name}\" with ObjectId = {$id}."
        ));
        //$this->halt(300);
    }
}