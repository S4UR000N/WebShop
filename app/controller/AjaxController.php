<?php

// namespace
namespace app\controller;

// class
class AjaxController
{
    public function getAllFiles()
    {
        \app\extra\AjaxRequest::getAllFiles();
	}
}
