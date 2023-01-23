<?php

class SongsCategoriesManager extends AbstractManager
{
	public function getAllSongsCategories() : array
	{
		$query = $this->db->prepare('SELECT * FROM songs_categories');
		$query->execute();
		$allCats = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allCats;
	}

	public function getCatNameById($id) : string
	{
		$query = $this->db->prepare('SELECT name FROM songs_categories WHERE id = :id');
		$parameters = [
			'id' => $id
			];
		$query->execute($parameters);
		$catName = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $catName["id"];
	}

}