<?php

class SahringItemManager extends AbstractManager
{
	public function createSharingItem(int $userId, string $title, string $content, int $categoryId) : void
	{
		$query = $this->db->prepare('INSERT INTO sharing_items (user_id, title, content, category_id)
		VALUES (:user_id, :title, :content, :category_id)');
		$parameters = [
			'user_id' => $userId,
			'title' => $title,
			'content' => $content,
			'category_id' => $categoryId
			];
		$query->execute($parameters);
	}

	public function getAllSharingItems() : array
	{
		$query = $this->db->prepare('SELECT sharing_items.*, users.name, sharing_categories.name AS catName FROM sharing_items JOIN users ON sharing_items.user_id = users.id JOIN sharing_categories ON sharing_items.category_id = sharing_categories.id ORDER BY date DESC');
		$query->execute();
		$allSharingItems = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allSharingItems;
	}

	public function getSharingItemsByCatId(int $categoryId) : array
	{
		$query = $this->db->prepare('SELECT sharing_items.*, users.name FROM sharing_items JOIN users On sharing_items.user_id = users.id WHERE category_id = :category_id ORDER BY date DESC');
		$parameters = [
			'category_id' => $categoryId
			];
		$query->execute($parameters);
		$sharingItems = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $sharingItems;
	}
}