<?php

// namespace
namespace app\model;

class LogoutModel
{
    public function __construct()
    {
        // Destroy Session
        session_destroy();

        // get Domain
        $domain = \app\super\Server::getDomain();

        // Redirect
        header("location: $domain/");
    }
}