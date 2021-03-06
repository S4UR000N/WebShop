<?php

// namespace
namespace app\super;

final class Session
{
    // properties
    private static $inst = null;

    // Singleton
    public function __construct()
    {
        //start session if it's not already running
        if(session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
    }
    public static function session() {
        if(self::$inst === null)
        {
            return self::$inst = new self();
        }
        return self::$inst;
    }

    // Setter
    public function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }
    public function setRating($key, $val)
    {
        $_SESSION["rating"][$key] = $val;
    }

    // Getter
    public function get($key, $default = null)
    {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return $default;
    }
    public function getRating($key, $default = null)
    {
        if(isset($_SESSION["rating"][$key])) {
            return $_SESSION["rating"][$key];
        }
        return $default;
    }

    // check if value exists
    public function isSet($key) {
        if(array_key_exists($key, $_SESSION))
        {
            return true;
        }
        return false;
    }
}
