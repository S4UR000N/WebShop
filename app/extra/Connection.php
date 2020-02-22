<?php

// namespace
namespace app\extra;

// use
use \PDO;

final class Connection
{
    // properties
    private static $inst = null;
    private $cred;
    private $con;

    // constructor
    private function __construct()
    {
        $this->cred = require "../env/conf.php";
        $this->con = new PDO("mysql:host=" . $this->cred['SERVER_NAME'] . ";dbname=" . $this->cred['DATABASE_NAME'], $this->cred['USERNAME'], $this->cred['PASSWORD']);
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // singleton
    public static function getInstance() {
        if(self::$inst === null)
        {
            self::$inst = new self();
        }
        return self::$inst;
    }

    public function getCon()
    {
        return $this->con;
    }
}