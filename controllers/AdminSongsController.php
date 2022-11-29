<?php

Class AdminSongsController extends AbstractController
{
	public function index() :void
	{
		$template = "adminSongs";
		$validation = "";
		$errors = [];
		$allSongs = $this->sm->getAllSongsTitles();

		if(isset($_POST["action"]) && $_POST["action"] === "addSong")
		{
			var_dump($_POST);
			if(!isset($_POST["title"]) || $_POST["title"] === "")
			{
				$errors[] = "Veuillez mettre un titre";
			}

			if($errors !== [])
			{
				$this->render($template, ["allSongs" => $allSongs, "errors" => $errors]);
			}
			else if($errors === [])
			{

			$this->sm->createSong($_POST["title"], $_POST["description"]);

			$validation = "Le nouveau chant à bien été créé";

			$this->render($template, ["allSongs" => $allSongs, "validation" => $validation]);
			}
		}

		$this->render($template, ["allSongs" => $allSongs]);
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

			if(!isset($_POST["voice"]) || $_POST["voice"] === "")
			{
				$errors[] = "Veuillez choisr le type de voix";
			}

			if(isset($_POST["voice"]) && $_POST["voice"] === "other" && $_POST["other"] === "")
			{
				$errors[] = 'Veuillez précisez le type de voix pour le choix "autre"';
			}

			if(isset($_POST["voice"]) && $_FILES["fileToUpload"]["name"] === "")
			{
				$errors[] = "Veuillez sélectionner un fichier";
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
				$this->render($template, ["title" => $title, "errors" => $errors]);
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
	{

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

			if(!isset($_FILES["fileToUpload"]["name"]) || $_FILES["fileToUpload"]["name"] === "")
			{
				$errors[] = "Veuillez sélectionner un fichier";
			}


			if($errors !== [])
			{
				$this->render($template, ["title" => $title, "errors" => $errors]);
			}
			else if($errors === [])
			{
				$file = $_FILES;

				$titleForUpload = str_replace([" ", "'"], "-", $title);

				$upload = $this->fu->uploadText($file, $songId, $titleForUpload);
				$text = $upload["fileToUpload"];

				$this->tm->createText($text);
				
				$validation = "Votre texte a été chargé correctement";

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

		if(isset($_POST["action"]) && $_POST["action"] === "addVideo")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);
	
			$this->render($template, ["title" => $title]);

		}
		else if(isset($_POST["action"]) && $_POST["action"] === "addVideoLink")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);
	
			if(!isset($_POST["urlVideo"]) || $_POST["urlVideo"] === "")
			{
				$errors[] = "Veuillez renseigner le lien";
			}

			if($errors !== [])
			{
				$this->render($template, ["title" => $title, "errors" => $errors]);
			}
			else if($errors === [])
			{

				$urlVideo = $_POST["urlVideo"];

				$this->sm->updateUrlVideo($songId, $urlVideo);

				$validation = "Le lien a bien été enregistré";

				$this->render($template, ["title" => $title, "validation" => $validation]);
			}

			$this->render($template, ["title" => $title]);

		}
		else if(!isset($_POST["action"]) || $_POST["action"] === "")
		{
			$template = "adminSongs";

			$allSongs = $this->sm->getAllSongsTitles();

			$this->render($template, ["allSongs" => $allSongs]);
		}
	}

	public function addCurrent() : void
	{
		$template = "adminCurrent";

		if(isset($_POST["action"]) && $_POST["action"] === "addCurrent")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);
	
			$this->render($template, ["title" => $title]);

		}
		else if(isset($_POST["action"]) && $_POST["action"] === "updateStatus")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);
	
			if(!isset($_POST["status"]) || $_POST["status"] === "")
			{
				$errors[] = "veuillez choisir un statut";
			}

			if(!isset($errors) || $errors === [])
			{
				$status = $_POST["status"];
				$this->sm->updateCurrent($songId, $status);
				$validation = "Le statut a bien été changé";
	
				$this->render($template, ["title" => $title, "validation" => $validation]);
			}
			else
			{
				$this->render($template, ["title" => $title, "errors" => $errors]);
			}
			
		}
		else if(!isset($_POST["action"]) || $_POST["action"] === "")
		{
			$template = "adminSongs";

			$allSongs = $this->sm->getAllSongsTitles();

			$this->render($template, ["allSongs" => $allSongs]);
		}
	}

}