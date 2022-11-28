<?php

class SongsManager extends AbstractManager
{
    public function createSong(Song $song) : void
    {
        $query = $this->db->prepare('INSERT INTO songs (title, description, current_song)
        VALUES (:title, :description, :current_song)');
        $parameters = [
            'title' => $song->getTitle(),
            'description' => $song->getDescription(),
            'current_song' => $song->getCurrentSong()
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

}