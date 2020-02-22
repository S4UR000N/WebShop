<?php

// namespace
namespace app\super;

final class Get
{
    private $get;

    public function __construct()
    {
        //add $_Get to our $get property
        $this->get = $_GET;
    }
}