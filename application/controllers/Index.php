<?php

/**
 * Class Index
 * The index controller
 */
class Index extends Controller
{
    /**
     * Handles what happens when user moves to URL/index/index, which is the same like URL/index or in this
     * case even URL (without any controller/action) as this is the default controller-action when user gives no input.
     */
    function index()
    {
            $this->render('index/index');
    }
}
