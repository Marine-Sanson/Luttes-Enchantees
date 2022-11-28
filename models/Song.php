<?php

class Song
{
	private ?int $id;
	private string $title;
	private string $description;
	private string $urlVideo;
	private bool $currentSong;

	function __construct(?int $id, string $title, string $description, string $urlVideo, bool $currentSong)
	{
		$this->id = $id;
		$this->title = $title;
		$this->description = $description;
		$this->urlVideo = $urlVideo;
		$this->currentSong = $currentSong;
	}

	public function getId() : ?int
	{
		return $this->id;
	}
	
	public function setId(?int $id) : void
	{
		$this->id = $id;
	}

	public function getTitle() : string
	{
		return $this->title;
	}
	
	public function setTitle(string $title) : void
	{
		$this->title = $title;
	}

	public function getDescription() : string
	{
		return $this->description;
	}
	
	public function setDescription(string $description) : void
	{
		$this->description = $description;
	}

	public function getUrlVideo() : string
	{
		return $this->urlVideo;
	}
	
	public function setUrlVideo(string $urlVideo) : void
	{
		$this->urlVideo = $urlVideo;
	}

		public function getCurrentSong() : bool
	{
		return $this->currentSong;
	}
	
	public function setCurrentSong(bool $currentSong) : void
	{
		$this->currentSong = $currentSong;
	}

}

