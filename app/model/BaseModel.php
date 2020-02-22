<?php

// namespace
namespace app\model;

class BaseModel
{
    // properties
    private $_data = [];

    // setter
    public function __set($okey, $oval)
    {
        $this->_data[$okey] = $oval;
    }
    // getter
    public function __get($okey)
    {
        return isset($this->_data[$okey]) ? $this->_data[$okey] : null;
    }
    // call
    public function __call($method, $arguments)
    {
        switch(substr($method, 0, 3)) {
            case 'set':
                $this->__set($this->_toSnakeCase(substr($method, 3)), $arguments[0]);
                return $this;
                break;
            case 'get':
                return $this->__get($this->_toSnakeCase(substr($method, 3)));
                break;
            default:
                trigger_error("Call to undefined method " . __CLASS__ . "::$method()", E_USER_ERROR);
        }
    }
    protected function _toSnakeCase($name)
    {
        return strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
    }
}