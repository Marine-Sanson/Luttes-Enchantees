<?php

Class AdminSongsController extends AbstractController
{

	public function index() :void
	{
		//Si le user est connecté et que son role est admin
		if($_SESSION["connectUser"] && $_SESSION["user"]["role"] === "admin")
		{
			//va chercher les titres de toutes les chansons et appelle le template
			$template = "adminSongs";
			$validation = "";
			$allSongs = $this->sm->getAllSongsTitles();
	
			//Si l'action est "addSongs" vérifie que le formulaire est correctement rempli, sinon rempli le tableau d'erreurs
			if(isset($_POST["action"]) && $_POST["action"] === "addSong")
			{
				$errors = [];
				if(!isset($_POST["title"]) || $_POST["title"] === "")
				{
					$errors[] = "Veuillez mettre un titre";
				}
	
				if($errors !== [])
				{
					$this->render($template, ["allSongs" => $allSongs, "errors" => $errors]);
				}
				else if(!isset($errors) || $errors === [])
				{
					$this->sm->createSong($_POST["title"], $_POST["description"]);
					$validation = "Le nouveau chant à bien été créé";
	
					$allSongs = $this->sm->getAllSongsTitles();
					$this->render($template, ["allSongs" => $allSongs, "validation" => $validation]);
				}
			}
			//Si le POST "action n'est pas set
			else if(!isset($_POST["action"]))
			{
				//Va chercher toutes les chansons et appelle le template
				$allSongs = $this->sm->getAllSongsTitles();
				$this->render($template, ["allSongs" => $allSongs]);
			}	
		}
		else
		{
			//Sinon redirige vers membersHome, en allant chercher tous les events
			$allEvents = $this->em->getEvents();
			$events = [];

			foreach($allEvents as $key => $event)
			{
				$cat = $this->em->getCatById($event["event_cat_id"]);
				$part = $this->pm->getParticipationStatus($event["id"], $_SESSION["user"]["id"]);
				$events[] = [
					"id" => $event["id"],
					"date" => $event["date"],
					"event_cat_id" => $event["event_cat_id"],
					"cat" => $cat,
					"part" => $part,
					"private_details" => $event["private_details"]
				];
			}
			$template = "membersHome";

			$this->render($template, ["events" => $events]);
		}
	}

	public function addVoice() : void
	{
		//Si l'action est "uploadVoice" vérifie que le formulaire est correctement rempli, sinon rempli le tableau d'erreurs
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

				if($_POST["voice"] === "other")
				{
					$voiceType = "Voix " . $_POST["other"];
				}
				else if($_POST["voice"] === "Tutti")
				{
					$voiceType = "Tutti";
				}
				else if($_POST["voice"] === "demo")
				{
					$voiceType = "demo";
				}
				else
				{
					$voiceType = "Voix " . $_POST["voice"];
				}				

				//Remplace " " et "'" par "-" dans le titre
				$titleForUpload = str_replace([" ", "'"], "-", $title);

				//Upload le fichier son
				$upload = $this->fu->uploadVoice($file, $songId, $titleForUpload, $voiceType);
				$voice = $upload["fileToUpload"];

				//Crée la voix dans le manager
				$this->vm->createVoice($voice);

				$validation = "le fichier à bien été ajouté";

				$this->render($template, ["title" => $title, "validation" => $validation]);
			}
		}
		//Sinon si l'action est "addVoice" va chercher le titre du chant d'après son id
		else if(isset($_POST["action"]) && $_POST["action"] === "addVoice")
		{
			$title = $this->sm->getSongTitle($_POST["songId"]);

			$template = "adminAddVoice";

			$this->render($template, ["title" => $title]);
		}
		//Sinon si l'action n'est pas set, appelle "adminSongs"
		else if(!isset($_POST["action"]))
		{
			$template = "adminSongs";
			$allSongs = $this->sm->getAllSongsTitles();

			$this->render($template, ["allSongs" => $allSongs]);
		}
	}

	public function addText() : void
	{
		//Si l'action est "uploadText" vérifie que le formulaire est correctement rempli, sinon rempli le tableau d'erreurs
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
			//Si la tableau d'erreurs est vide, upload le texte
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
		//Sinon si l'action est "addText" va chercher le titre du chant d'après son id
		else if(isset($_POST["action"]) && $_POST["action"] === "addText")
		{
			$title = $this->sm->getSongTitle($_POST["songId"]);
			$template = "adminAddText";

			$this->render($template, ["title" => $title]);
		}
		else
		{
			//Sinon si l'action n'est pas set, appelle "adminSongs"
			$template = "adminSongs";
			$allSongs = $this->sm->getAllSongsTitles();

			$this->render($template, ["allSongs" => $allSongs]);
		}
	}

	public function addVideo() : void
	{
		$template = "adminAddVideo";

		//Si l'action est "addVideo" va chercher le titre du chant d'après son id
		if(isset($_POST["action"]) && $_POST["action"] === "addVideo")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);
	
			$this->render($template, ["title" => $title]);

		}
		//Sinon si l'action est "addVideoLink" vérifie que le formulaire est correctement rempli, sinon rempli le tableau d'erreurs
		else if(isset($_POST["action"]) && $_POST["action"] === "addVideoLink")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);
	
			if(!isset($_POST["urlVideo"]) || $_POST["urlVideo"] === "")
			{
				$errors[] = "Veuillez renseigner le lien";
			}

			if(!isset($errors) || $errors === [])
			{
				//Si le tableau d'erreurs est vide, update le lien vidéo
				$urlVideo = $_POST["urlVideo"];
				$this->sm->updateUrlVideo($songId, $urlVideo);
				$validation = "Le lien a bien été enregistré";

				$this->render($template, ["title" => $title, "validation" => $validation]);
			}
			else if($errors !== [])
			{
				$this->render($template, ["title" => $title, "errors" => $errors]);
			}

			$this->render($template, ["title" => $title]);

		}
		//Sinon, redirige vers "adminSongs"
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
		
		//Si l'action est "addCurrent" va chercher le titre du chant d'après son id
		if(isset($_POST["action"]) && $_POST["action"] === "addCurrent")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);
	
			$this->render($template, ["title" => $title]);

		}
		//Sinon si l'action est "updateStatus" vérifie que quelque chose est coché, sinon rempli le tableau d'erreurs
		else if(isset($_POST["action"]) && $_POST["action"] === "updateStatus")
		{
			$songId = intval($_POST["songId"]);
			$title = $this->sm->getSongTitle($songId);
	
			if(!isset($_POST["status"]) || $_POST["status"] === "")
			{
				$errors[] = "veuillez choisir un statut";
			}

			//Si le tableau d'erreurs est vide, update le status
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
		//Sinon, redirige vers "adminSongs"
		else if(!isset($_POST["action"]) || $_POST["action"] === "")
		{
			$template = "adminSongs";

			$allSongs = $this->sm->getAllSongsTitles();

			$this->render($template, ["allSongs" => $allSongs]);
		}
	}
}