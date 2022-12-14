<?php

class TextManager extends AbstractManager
{
	public function createText(Text $text) : void
	{
		$query = $this->db->prepare('INSERT INTO texts (song_id, original_name, file_name, file_type, url, alt)
		VALUES (:song_id, :original_name, :file_name, :file_type, :url, :alt)');
		$parameters = [
			'song_id' => $text->getSongId(),
			'original_name' => $text->getOriginalName(),
			'file_name' => $text->getFileName(),
			'file_type' => $text->getFileType(),
			'url' => $text->getUrl(),
			'alt' => $text->getAlt()
			];
		$query->execute($parameters);
	}

	public function getTextBySongId(int $songId) : array
	{
		$query = $this->db->prepare('SELECT * FROM texts WHERE song_id = :song_id');
		$parameters = [
			'song_id' => $songId
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		if($result !== [])
		{
			$text = $result[0];
		}
		else
		{
			$text = [];
		}

		return $text;
	}
}