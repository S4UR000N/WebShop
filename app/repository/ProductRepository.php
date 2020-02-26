<?php

// namespace
namespace app\repository;

// class
class ProductRepository extends BaseRepository
{
	public function selectAllProducts() {
		$DB = $this->con->query("SELECT * FROM products WHERE 1")->fetchAll(\PDO::FETCH_ASSOC);
		return $DB;
	}
}
