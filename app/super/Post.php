<?php

// namespace
namespace app\super;

final class Post
{
    // properties
    private static $inst = null;

    // Singleton
    public static function post() {
        if(self::$inst === null)
        {
            return self::$inst = new self();
        }
        return self::$inst;
    }

    // Setter
    public function set($key, $val)
    {
        $_POST[$key] = $val;
    }

    // Getter
    public function get($key, $default = null)
    {
        if(isset($_POST[$key])) {
            return $_POST[$key];
        }
        return $default;
    }

    // check if value exists
    public function isSet($key) {
        if(array_key_exists($key, $_POST))
        {
            return true;
        }
        return false;
    }

    // return $_POST superglobal array
    public function getPost()
    {
        return $_POST;
    }
}
