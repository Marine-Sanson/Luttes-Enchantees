<?php

Class MembersSongsController extends AbstractController
{
	public function index() :void
	{
		if($_SESSION["connectUser"])
		{
			$template = "membersSongs";

			$outOfCatSongs = $this->sm->getOutOfCatSongsTitles();
			$currentYearSongs = $this->sm->getCurrentYearSongsTitles();
			$sharedSongs = $this->sm->getSharedSongsTitles();
			$oldSongs = $this->sm->getOldSongsTitles();
			
			$this->render($template, ["outOfCatSongs" => $outOfCatSongs, "currentYearSongs" => $currentYearSongs, "sharedSongs" => $sharedSongs, "oldSongs" => $oldSongs]);
		}
		else
		{
			$template = "connect";

			$this->render($template);
		}
	}

	public function songDetail() :void
	{
		if($_SESSION["connectUser"])
		{
			$template = "membersSongDetail";

			$song = $this->sm->getSongDetails($_POST["id"]);
			$voices = $this->vm->getVoicesBySongId($_POST["id"]);
			$text = $this->tm->getTextBySongId(intval($song["id"]));
			
			$this->render($template, ["song" => $song, "voices" => $voices, "text" => $text]);
		}
		else
		{
			$template = "connect";

			$this->render($template);
		}
	}
}