<?php

class SahringItemManager extends AbstractManager
{
	public function createSahringItem(int $userId, string $title, string $content, int $categoryId) : void
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
		$query = $this->db->prepare('SELECT * FROM sharing_items');
		$query->execute();
		$allSharingItems = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allSharingItems;
	}
}