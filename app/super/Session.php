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
            if (!isset($_SESSION))
            {
              session_start();
            }
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

    // Getter
    public function get($key, $default = null)
    {
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return $default;
    }

    public function isSet($key) {
        if(array_key_exists($key, $_SESSION))
        {
            return true;
        }
        return false;
    }
}
