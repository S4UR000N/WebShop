<?php

// namespace
namespace app\extra;

final class Request
{
    /**
     * returns path if there is (/path)
     * returns false if root path (/)
     */
    public static function pathinfo()
    {
        $server = new \app\super\Server();
        return $server->getRedirectURL();
    }

    /**
     * returns true on POST
     * returns false on GET
     */
    public static function requestMethod()
    {
        $server = new \app\super\Server();
        return $server->isPost();
    }

    /**
     * returns true if user is loged in
     * return false if user is NOT loged in
     */
    public static function isLogdIn()
    {
        $session = new \app\super\Session();
        return $session->isSet();
    }
}
