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

	public function getOutOfCatSongsTitles() : array
	{
		$query = $this->db->prepare('SELECT id, title FROM songs WHERE category_id = 0');
		$query->execute();
		$allSongs = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allSongs;
	}

	public function getCurrentYearSongsTitles() : array
	{
		$query = $this->db->prepare('SELECT id, title FROM songs WHERE category_id = 1');
		$query->execute();
		$allSongs = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allSongs;
	}

	public function getSharedSongsTitles() : array
	{
		$query = $this->db->prepare('SELECT id, title FROM songs WHERE category_id = 2');
		$query->execute();
		$allSongs = $query->fetchAll(PDO::FETCH_ASSOC);
		
		return $allSongs;
	}

	public function getOldSongsTitles() : array
	{
		$query = $this->db->prepare('SELECT id, title FROM songs WHERE category_id = 3');
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

	public function getSongStatus(int $id) : bool
	{
		$query = $this->db->prepare('SELECT current_song FROM songs WHERE id = :id');
		$parameters = [
			'id' => $id
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$status = $result[0]["current_song"];

		return $status;
	}

	public function getSongCat(int $songId) : int
	{
		$query = $this->db->prepare('SELECT category_id FROM songs WHERE id = :id');
		$parameters = [
			'id' => $songId
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$catId = intval($result[0]["category_id"]);

		return $catId;
	}

	public function getSongDesc(int $songId) : string
	{
		$query = $this->db->prepare('SELECT description FROM songs WHERE id = :id');
		$parameters = [
			'id' => $songId
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$desc = $result[0]["description"];

		return $desc;
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

	public function updateSongCat(int $id, int $catId) : void
	{
		$query = $this->db->prepare('UPDATE songs SET category_id = :category_id WHERE id = :id');
		$parameters = [
			'id' => $id,
			'category_id' => $catId
			];
		$query->execute($parameters);
	}

	public function updateSong(int $id, string $title, string $description) : void
	{
		$query = $this->db->prepare('UPDATE songs SET title = :title, description = :description WHERE id = :id');
		$parameters = [
			'id' => $id,
			'title' => $title,
			'description' => $description
			];
		$query->execute($parameters);
	}

}