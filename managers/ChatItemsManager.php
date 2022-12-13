<?php

class ChatItemsManager extends AbstractManager
{
	public function createChatItem(int $userId, string $title, string $content) : void
	{
		$query = $this->db->prepare('INSERT INTO chat_items (user_id, title, message)
		VALUES (:user_id, :title, :message)');
		$parameters = [
			'user_id' => $userId,
			'title' => $title,
			'message' => $content
			];
		$query->execute($parameters);
	}

	public function getAllChatItems() : array
	{
		$query = $this->db->prepare('SELECT chat_items.*, users.name FROM chat_items JOIN users ON chat_items.user_id = users.id ORDER BY date DESC');
		$query->execute();
		$allChatItems = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allChatItems;
	}
}