<?php

// namespace
namespace app\controller;


class CollectionController
{
    // properties
    public $files;

    // constructor
    public function __construct()
    {
        // estsblish DB connection and get all files data
        $con = \app\extra\Connection::getInstance()->getCon();
        $queryData = $con->query("SELECT * FROM files;")->fetchAll(\PDO::FETCH_OBJ);

        // inst collection and pass FileModel
        $this->files = new \app\extra\Collection($queryData, 'FileModel');
    }

    /* Samples */
    public function sample1()
    {
        echo "Number of files: (this) ", $this->files->count(), ";  Number of files: (count only) ", count($this->files), ";<br>", "Files: <br>";
        echo "[key:file_id:file_name]<br>";
        $this->files->each(function($file, $key) {
            echo $key . ":" . $file->file_id . ":" . $file->file_name . "<br>";
        });
    }
    public function sample2()
    {
        echo "FIRST<br>";
        var_dump($this->files->first());
        echo "LAST<br>";
        var_dump($this->files->last());
    }
    public function sample3()
    {
        $this->files = $this->files->filter(function($file) {
            return $file->file_id >= 69;
        });

        var_dump($this->files);
    }
    public function sample4()
    {
        $this->files = $this->files->map(function($file) {
            $file->file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->file_name);
            return $file;
        });
        var_dump($this->files);
    }
    public function sample5()
    {
        $con = \app\extra\Connection::getInstance()->getCon();
        $queryData = $con->query("SELECT * FROM files;")->fetchAll(\PDO::FETCH_OBJ);
        $this->files = $this->files->merge($queryData);
        var_dump($this->files);
    }

    public function sample6()
    {
        $con = \app\extra\Connection::getInstance()->getCon();
        $queryData = $con->query("SELECT * FROM files;")->fetchAll(\PDO::FETCH_OBJ);
        $col = new \app\extra\Collection($queryData);
        $this->files = $this->files->merge($col);
        var_dump($this->files);
    }
    public function sample7()
    {
        foreach($this->files as $file)
        {
            echo $file->file_name, "<br>";
        }
    }

    public function sample8()
    {
        $con = \app\extra\Connection::getInstance()->getCon();
        $queryData = $con->query("SELECT * FROM files;")->fetchAll(\PDO::FETCH_OBJ);
        $collection = new \app\extra\Collection($queryData);

        $this->files = $this->files->merge($collection);
        var_dump($this->files);
    }
}