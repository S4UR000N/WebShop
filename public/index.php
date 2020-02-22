<?php

//define base path, root path of our application
define('BP', dirname(__DIR__) . '/');

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

//start app
app\extra\Port::open();
