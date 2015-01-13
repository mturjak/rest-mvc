<?php

/**
 * Classes controller
 * 
 */
class Classes extends Controller
{
    /**
     * Default classes response - lists accessable classes (data tables)
     */
    public function index()
    {
        //$this->app->flashNow('info', 'Your credit card is expired');

        $this->render('classes/index', array(
            'message' => 'List of accessable classes.'
        ));
    }

    /**
     * Lists objects of class $name (records from data table)
     * @param string $name Class name
     */
    public function items($name)
    {
        $this->render('classes/index', array(
            'message' => "List of objects of class \"{$name}\"."
        ));
        //$error = 'Always throw this error';
        //throw new Exception($error, 400);
    }

    /**
     * Lists objects of class $name (records from data table)
     * @param string $name Class name
     */
    public function show($name, $id)
    {
        $this->render('classes/view', array(
            'message' => "Single object of class \"{$name}\" with ObjectId = {$id}."
        ));
        //$this->halt(300);
    }
}