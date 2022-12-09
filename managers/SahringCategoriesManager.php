<?php

class SahringCategoriesManager extends AbstractManager
{
	public function getAllCategories() : array
	{
		$query = $this->db->prepare('SELECT * FROM sharing_categories');
		$query->execute();
		$allCats = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allCats;
	}

	public function getCatNameById($id) : string
	{
		$query = $this->db->prepare('SELECT name FROM sharing_categories WHERE id = :id');
		$parameters = [
			'id' => $id
			];
		$query->execute($parameters);
		$allCats = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allCats["id"];
	}
}