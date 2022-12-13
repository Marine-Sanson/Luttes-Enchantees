<?php

class ChatAnswersManager extends AbstractManager
{
	public function createChatAnswer(int $chatId, int $userId, string $content) : void
	{
		$query = $this->db->prepare('INSERT INTO chat_answers (chat_item_id, user_id, content)
		VALUES (:chat_item_id, :user_id, :content)');
		$parameters = [
			'chat_item_id' => $chatId,
			'user_id' => $userId,
			'content' => $content
			];
		$query->execute($parameters);
	}

	public function getAllChatAnswers(int $chatId) : array
	{
		$query = $this->db->prepare('SELECT chat_answers.*, users.name FROM chat_answers JOIN users ON chat_answers.user_id = users.id WHERE chat_item_id = :chat_item_id ORDER BY id');
		$parameters = [
			'chat_item_id' => $chatId
			];
		$query->execute($parameters);
		$allChatAnswers = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allChatAnswers;
	}
}