<?php

// namespace
namespace app\layout;

final class LayoutLoader
{
    public static function loadBasicHTML()
    {
        $path = BP . "app/view/header/base.php";
        require $path;
    }

    public static function loadHeader()
    {
        $path = BP . "app/view/header/header.php";
        require $path;
    }
}
