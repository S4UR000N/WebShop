<?php

// namespace
namespace app\repository;

// class
class ProductRepository extends BaseRepository
{
	public function selectAllProducts()
	{
		$DB = $this->con->query("SELECT * FROM products WHERE 1")->fetchAll(\PDO::FETCH_ASSOC);
		return $DB;
	}

	public function selectProductsWhereIDs($IDs)
	{
		// build query
		$query = "SELECT * FROM `products` WHERE";
		foreach($IDs as $key => $id)
		{
			// prevent last element from concatenating "OR"
			if($key != (count($IDs) - 1))
			{
				$query .= " id='$id' OR";
			}
			else
			{
				$query .= " id='$id';";
			}
		}

		// execute query and return data
		$DB = $this->con->query($query)->fetchAll(\PDO::FETCH_ASSOC);
		return $DB;
	}
}
