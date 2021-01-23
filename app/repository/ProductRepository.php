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

	public function selectProductWhereID($id)
	{
		$statement = $this->con->prepare("SELECT * FROM products WHERE id = :id");

		$statement->bindParam(':id', $id);

		$result = $statement->execute();
		if($result)
		{
			$result = $statement->fetch(\PDO::FETCH_ASSOC);
		}
		return $result;
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

	public function updateRatingData($votes, $votes_value, $rating, $productID)
	{
		$statement = $this->con->prepare("UPDATE products SET votes = :votes, votes_value = :votes_value, rating = :rating WHERE id = :id");

		$statement->bindParam(':votes', $votes);
		$statement->bindParam(':votes_value', $votes_value);
		$statement->bindParam(':rating', $rating);
		$statement->bindParam(':id', $productID);

		$result = $statement->execute();
		return $result;
	}

}
