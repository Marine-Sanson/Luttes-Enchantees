<?php

Class MembersSongsController extends AbstractController
{
	public function index() :void
	{
		$template = "membersSongs";

		$allSongs = $this->sm->getAllSongsTitles();

		$this->render($template, ["allSongs" => $allSongs]);
	}

	public function songDetail() :void
	{
		$template = "membersSongDetail";

		$song = $this->sm->getSongDetails($_POST["id"]);
		$voices = $this->vm->getVoicesBySongId($_POST["id"]);
		
		$this->render($template, ["song" => $song, "voices" => $voices]);
	}
}