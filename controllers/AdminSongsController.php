<?php

Class AdminSongsController extends AbstractController
{
	public function index() :void
	{
		$template = "adminSongs";
		$validation = "";

		if(isset($_POST["action"]) && $_POST["action"] === "addSong")
		{
			
			$this->sm->createSong($_POST["title"], $_POST["description"]);

			$validation = "Le nouveau chant à bien été créé";

		}

		$allSongs = $this->sm->getAllSongsTitles();

		$this->render($template, ["allSongs" => $allSongs, "validation" => $validation]);

	}

	public function addVoice() : void
	{
		if(isset($_POST["action"]) && $_POST["action"] === "uploadVoice")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);

			$template = "adminAddVoice";
			$validation = "";
			if(isset($_POST["errors"]))
			{
				$errors = $_POST["errors"];
			}
			else
			{
				$errors = [];
			}

			if(isset($_POST["voice"]) && $_POST["voice"] !== "other")
				{
					$voice = $_POST["voice"];
				}
				else if(isset($_POST["voice"]) && $_POST["voice"] === "other")
				{
					$voice = $_POST["other"];
				}
				else
				{
					$errors[] = "choisir un type de voix";
				}

			if($errors !== [])
			{
				$this->render($template, ["title" => $title, "errors" => $_POST["errors"]]);
			}
			else if($errors === [])
			{
				$file = $_FILES;

				$voiceType = $_POST["voice"];

				$titleForUpload = str_replace([" ", "'"], "-", $title);
				var_dump($songId);

				$upload = $this->fu->uploadVoice($file, $songId, $titleForUpload, $voiceType);
				$voice = $upload["fileToUpload"];
				var_dump($voice);

				$this->vm->createVoice($voice);

				$validation = "le fichier à bien été ajouté";

				$this->render($template, ["title" => $title, "validation" => $validation]);
			}
		}
		else if(isset($_POST["action"]) && $_POST["action"] === "addVoice")
		{
			$title = $this->sm->getSongTitle($_POST["songId"]);

			$template = "adminAddVoice";

			$this->render($template, ["title" => $title]);
		}
		else
		{
			$template = "adminSongs";
			$allSongs = $this->sm->getAllSongsTitles();

			$this->render($template, ["allSongs" => $allSongs]);
		}
	}

	public function addText() : void
	{	var_dump($_POST);

		if(isset($_POST["action"]) && $_POST["action"] === "uploadText")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);

			$template = "adminAddText";
			$validation = "";
			if(isset($_POST["errors"]))
			{
				$errors = $_POST["errors"];
			}
			else
			{
				$errors = [];
			}

			if($errors !== [])
			{
				$this->render($template, ["title" => $title, "errors" => $_POST["errors"]]);
			}
			else if($errors === [])
			{
				$file = $_FILES;

				$titleForUpload = str_replace([" ", "'"], "-", $title);

				$upload = $this->fu->uploadText($file, $songId, $titleForUpload);
				$text = $upload["fileToUpload"];

				$this->tm->createText($text);
				
				$validation = "votre texte a été chargé correctement";

				$this->render($template, ["title" => $title, "validation" => $validation]);
			}
		}
		else if(isset($_POST["action"]) && $_POST["action"] === "addText")
		{
			$title = $this->sm->getSongTitle($_POST["songId"]);
			$template = "adminAddText";

			$this->render($template, ["title" => $title]);
		}
		else
		{
			$template = "adminSongs";
			$allSongs = $this->sm->getAllSongsTitles();

			$this->render($template, ["allSongs" => $allSongs]);
		}
	}

	public function addVideo() : void
	{
		$template = "adminAddVideo";
		$songId = intval($_POST["songId"]);
		$title = $this->sm->getSongTitle($songId);

		if(isset($_POST["action"]) && $_POST["action"] === "addVideoLink")
		{
			$urlVideo = $_POST["urlVideo"];

			$this->sm->updateUrlVideo($songId, $urlVideo);

		}

		var_dump($_POST);
		var_dump($_FILES);

		$allSongs = $this->sm->getAllSongsTitles();

		$this->render($template, ["title" => $title]);
	}

	public function addCurrent() : void
	{
		$template = "adminCurrent";
		$songId = intval($_POST["songId"]);
		$title = $this->sm->getSongTitle($songId);

		if(isset($_POST["action"]) && $_POST["action"] === "addCurrent")
		{
			$this->render($template, ["title" => $title]);

		}
		else if(isset($_POST["action"]) && $_POST["action"] === "updateStatus")
		{
			$status = $_POST["status"];
			$this->sm->updateCurrent($songId, $status);
			$validation = "Le statut a bien été changé";

			$this->render($template, ["title" => $title, "validation" => $validation]);
		}
		else
		{
			$allSongs = $this->sm->getAllSongsTitles();

			$this->render($template, ["allSongs" => $allSongs]);
		}
	}

}