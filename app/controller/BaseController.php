<?php

// namespace
namespace app\controller;

abstract class BaseController
{
    /**
     * deny access for loged in users
     */
    public function denyIn()
    {
        \app\extra\ErrorHandler::call401(\app\super\Session::isSet());
    }
    /**
     * deny access for non loged in users
     */
    public function denyOut()
    {
        \app\extra\ErrorHandler::call401(!\app\super\Session::isSet());
    }

    //render View, Parameter: 1 => Folder:File, 2 => Pass any Data to View
    /**
     * @param string $view Folder:File
     * @param array $viewData
     * @return mixed
     *
     * mixed: require __DIR__/app/view/Folder(optional)/File.php (first argument example)
     */
    public function render_view(string $view, $viewData = array())
    {
        //make path to view
        $path = BP . "/app/view";

        //set full path;
        $render = explode(":", $view);
        foreach($render as $bind)
        {
            $path .=  "/" . $bind;
        }

        $path .= ".php";

        //render view
        require_once $path;
    }
}