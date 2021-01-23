<?php

// namespace
namespace app\repository;

// abstract class BaseController
abstract class BaseRepository
{
  // properties
  protected $con;

  // open Connection
  public function __construct()
  {
      $this->con = \app\extra\Connection::getInstance()->getCon();
  }
}
