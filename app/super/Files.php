<?php

// namespace
namespace app\super;

final class Files
{
    // properties
    private static $inst = null;
    
    // Singleton
    public static function files()
    {
        if(self::$inst === null)
        {
            return self::$inst = new self();
        }
        return self::$inst;
    }

    // Getter
    public function get($key)
    {
        if(isset($_FILES[$key])) {
            return $_FILES[$key];
        }
        return false;
    }

    public function getFiles() {
        return $_FILES;
    }
}
