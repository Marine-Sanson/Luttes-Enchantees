<?php

class ShareAnswerManager extends AbstractManager
{
	public function createShareAnswer(int $sharingItemId, int $userId, string $content) : void
	{
		$query = $this->db->prepare('INSERT INTO share_answers (sharing_item_id, user_id, content)
		VALUES (:sharing_item_id, :user_id, :content)');
		$parameters = [
                  'sharing_item_id' => $sharingItemId,
			'user_id' => $userId,
			'content' => $content
			];
		$query->execute($parameters);
	}

	public function getAllShareAnswersBySharingItemId(int $sharingItemId) : array
	{
		$query = $this->db->prepare('SELECT share_answers.*, users.name FROM share_answers JOIN users On share_answers.user_id = users.id WHERE sharing_item_id = :sharing_item_id');
		$parameters = [
			'sharing_item_id' => $sharingItemId
			];
		$query->execute($parameters);
		$ShareAnswers = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $ShareAnswers;
	}


}