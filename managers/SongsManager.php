<?php

class SongsManager extends AbstractManager
{
	public function createSong(string $title, string $description) : void
	{
		$query = $this->db->prepare('INSERT INTO songs (title, description)
		VALUES (:title, :description)');
		$parameters = [
			'title' => $title,
			'description' => $description
			];
		$query->execute($parameters);
	}

	public function getAllSongsTitles() : array
	{
		$query = $this->db->prepare('SELECT id, title FROM songs');
		$query->execute();
		$allSongs = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allSongs;
	}

	public function getSongTitle($id) : string
	{
		$query = $this->db->prepare('SELECT title FROM songs WHERE id = :id');
		$parameters = [
			'id' => $id
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		$title = $result[0]["title"];
		
		return $title;
	}

	public function updateUrlVideo(int $songId, string $urlVideo)
	{
		$query = $this->db->prepare('UPDATE songs SET url_video = :urlVideo WHERE id = :id');
		$parameters = [
			'id' => $songId,
			'urlVideo' => $urlVideo
			];
		$query->execute($parameters);
	}

	public function updateCurrent(int $songId, int $current)
	{
		$query = $this->db->prepare('UPDATE songs SET current_song = :current_song WHERE id = :id');
		$parameters = [
			'id' => $songId,
			'current_song' => $current
			];
		$query->execute($parameters);
	}

}