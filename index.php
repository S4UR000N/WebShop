<?php

//define base path, root path of our application
define('BP', __DIR__ . '/');

//enable error_reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

//autoload classes using namespaces
spl_autoload_register(function ($classname)
{
    $file = BP . $classname . '.php';
    $file = str_replace('\\', '/', $file);
    if(file_exists($file))
    {
        require_once($file);
    }
});

// load basic html and css
\app\layout\LayoutLoader::loadBasicHTML();
\app\layout\LayoutLoader::loadHeader();

//start app
$controller = new \app\controller\WebshopController();
$controller->webshop();
