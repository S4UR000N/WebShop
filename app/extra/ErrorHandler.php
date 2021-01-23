<?php

// namespace
namespace app\extra;


class ErrorHandler
{
    public static function call401($cond)
    {
        if($cond) {
            require BP . "errors/401.php";
            die();
        }
    }

    public static function call404()
    {
        return require BP . "errors/404.php";
    }

    public static function call500()
    {
        return require BP . "errors/500.php";
    }
}
