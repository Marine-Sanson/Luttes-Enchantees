<?php

class VoiceManager extends AbstractManager
{
	public function createVoice(Voice $voice) : void
		{
			$query = $this->db->prepare('INSERT INTO voices (song_id, voice_type, original_name, file_name, file_type, url)
			VALUES (:song_id, :voice_type, :original_name, :file_name, :file_type, :url)');
			$parameters = [
				'song_id' => $voice->getSongId(),
				'voice_type' => $voice->getVoiceType(),
				'original_name' => $voice->getOriginalName(),
				'file_name' => $voice->getFileName(),
				'file_type' => $voice->getFileType(),
				'url' => $voice->getUrl()
				];
			$query->execute($parameters);
		}

		public function getVoicesBySongId($songId) : array
		{
			$query = $this->db->prepare('SELECT * FROM voices WHERE song_id = :song_id');
			$parameters = [
				'song_id' => $songId
				];
			$query->execute($parameters);
			$voices = $query->fetchAll(PDO::FETCH_ASSOC);

			return $voices;
		}
}
