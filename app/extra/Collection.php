<?php

// namespace
namespace app\extra;

// use
use app\model\FileModel;

/**
 * Class Collection
 * @namespace app\extra
 * pass only first argument like (query->fetchAll(FETCH::OBJ)) if you don't have model |
 * pass second argument if you want data to be sorted to certain model that is compaible with your DB table
 */
class Collection implements \Countable, \IteratorAggregate
{
    protected $items;
    protected $models = [];

    public function __construct($items = [], string $modelName = null)
    {
        $this->items = is_array($items) ? $items : $this->makeArray($items);
        if($modelName)
        {
            foreach($this->items as $key => $obj)
            {
                $model = new FileModel();
                foreach($obj as $okey => $oval)
                {
                    $model->$okey = $oval;
                }
                $this->models[$key] = $model;
            }
            $this->items = $this->models;
            unset($this->models);
        }
        else
        {
            unset($this->models);
        }
    }

    /**
     * @return array
     * returns all items
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @return array
     * return keys
     */
    public function keys()
    {
        return new static(array_keys($this->items));
    }

    /**
     * @return int
     * returns number of items
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @return bool
     * if empty return true |
     * if NOT empty return false
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * @param null $default
     * @return mixed|null
     * returns first item |
     * or null on empty array
     */
    public function first($default = null)
    {
        return isset($this->items[0]) ? $this->items[0] : $default;
    }

    /**
     * @param null $default
     * @return mixed|null
     * returns last item |
     * or null on empty array
     */
    public function last($default = null)
    {
        $reversed = array_reverse($this->items);
        return isset($reversed[0]) ? $reversed[0] : $default;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function each(callable $callback)
    {
        foreach($this->items as $key => $item)
        {
             $callback($item, $key);
        }
        return $this;
    }

    /**
     * @param callable|null $callback
     * @return Collection
     */
    public function filter(callable $callback = null)
    {
        if($callback)
        {
            return new static(array_filter($this->items, $callback));
        }
        return new static(array_filter($this->items));
    }

    /**
     * @param callable $callback
     * @return array|false
     */
    public function map(callable $callback)
    {
        $keys = $this->keys()->all();
        $items = array_map($callback, $this->items, $keys);

        return array_combine($keys, $items);
    }

    /**
     * @param array $items
     * @return Collection
     * binds given data to items property
     */
    public function merge($items)
    {
        if(is_array($items))
        {
            return new static(array_merge($this->items, $items));
        }
        else
        {
            return new static(array_merge($this->items, $this->makeArray($items)));
        }
    }


    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    public function makeArray($items)
    {
        if($items instanceof \app\extra\Collection)
        {
            return $items->all();
        }
    }
}