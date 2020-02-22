<?php

// namespace
namespace app\extra;

final class AjaxRequest
{
    /**
     * return all files from DB
     */
    public static function getAllFiles()
    {
        $ajax = new \app\model\AjaxModel();
        return $ajax->getAllFiles();
    }
}
