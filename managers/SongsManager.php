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

	public function getSongTitle(int $id) : string
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

	public function getSongDetails(int $id) : array
	{
		$query = $this->db->prepare('SELECT * FROM songs WHERE id = :id');
		$parameters = [
			'id' => $id
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		$song = $result[0];
		
		return $song;
	}

	public function getCurrentSongs() : array
	{
		$query = $this->db->prepare('SELECT * FROM songs WHERE current_song = :current_song');
		$parameters = [
			'current_song' => 1
			];
		$query->execute($parameters);
		$songs = $query->fetchAll(PDO::FETCH_ASSOC);

		return $songs;
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