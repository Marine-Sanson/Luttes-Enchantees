<?php

Class MembersSharingZoneController extends AbstractController
{
	public function index() : void
	{
		if($_SESSION["connectUser"])
		{
			$template = "membersSharingZone";
			$allCats = $this->scm->getAllCategories();
			$allShares = [];
			$allMessages = $this->sim->getAllSharingItems();
			foreach($allMessages as $key => $share)
			{
				$answers = $this->sam->getAllShareAnswersBySharingItemId($share["id"]);
				$share["answers"] = $answers;
				$allShares[] = $share;
			}

			if (isset($_POST["action"]) && $_POST["action"] === "shareAnswer")
			{
				if(!isset($_POST["shareAnswerContent"]) || $_POST["shareAnswerContent"] === "")
				{
					$allMessages = $this->sim->getAllSharingItems();
					foreach($allMessages as $key => $share)
					{
						$answers = $this->sam->getAllShareAnswersBySharingItemId($share["id"]);
						$share["answers"] = $answers;
						$allShares[] = $share;
					}
					
					$template = "membersSharingZone";
					$allCats = $this->scm->getAllCategories();
					$catName = $_POST["catName"];
					$errors[] = "attention a bien compléter ta réponse";
		
					$this->render($template, ["errors" => $errors, "allShares" => $allShares, "catName" => $catName, "allCats" => $allCats]);
				}
				else
				{
					$this->sam->createShareAnswer($_POST["shareId"], $_SESSION["user"]["id"], $_POST["shareAnswerContent"]);
					$validation = "Ta réponse a bien été prise en compte";
		
					$allMessages = $this->sim->getAllSharingItems();
					foreach($allMessages as $key => $share)
					{
						$answers = $this->sam->getAllShareAnswersBySharingItemId($share["id"]);
						$share["answers"] = $answers;
						$allShares[] = $share;
					}

					$template = "membersSharingZone";
					$allCats = $this->scm->getAllCategories();
					$catName = $_POST["catName"];
					$validation = "ta réponse à bien été enregistrée";
		
					$this->render($template, ["validation" => $validation, "allShares" => $allShares, "catName" => $catName, "allCats" => $allCats]);
				}
			}
			else
			{
				$this->render($template, ["allCats" => $allCats, "allShares" => $allShares]);
			}
		}
		else
		{
			$template = "connect";

			$token = $this->generateToken(20);
			$_SESSION["tokenRequiredForMemberConnection"] = $token;
	
			$this->render($template, ["token" => $token]);
		}
	}

	public function newShare() : void
	{
		if($_SESSION["connectUser"])
		{
			if(isset($_POST["action"]) && $_POST["action"] === "newSharingMessage")
			{
				$template = "membersNewShare";
				$allCats = $this->scm->getAllCategories();
		
				$this->render($template, ["allCats" => $allCats]);
			}
			else if(isset($_POST["action"]) && $_POST["action"] === "newShare")
			{
				$errors = [];
				if(!isset($_POST["title"]) || $_POST["title"] === "" )
				{
					$errors[] = "N'oublie pas de mettre un titre";
				}

				if(!isset($_POST["content"]) || $_POST["content"] === "")
				{
					$errors[] = "N'oublie pas de mettre un contenu";
				}

				if($errors === [])
				{
					$userId = $_SESSION["user"]["id"];
					$title = $_POST["title"];
					$content = $_POST["content"];
					$categoryId = $_POST["catId"];

					$this->sim->createSharingItem($userId, $title, $content, $categoryId);
					$validation = "Ton message a bien été créé";

					$template = "newShare";
					$allCats = $this->scm->getAllCategories();
			
					$this->render($template, ["allCats" => $allCats, "validation" => $validation]);
				}
				else if($errors !== [])
				{
					$template = "membersNewShare";
					$allCats = $this->scm->getAllCategories();
					$allMessages = $this->sim->getAllSharingItems();

					$title = "";
					$content = "";

					if(isset($_POST["title"]) || $_POST["title"] !== "" )
					{
						$title = $_POST["title"];
					}

					if(!isset($_POST["content"]) || $_POST["content"] === "")
					{
						$content = $_POST["content"];
					}
			
					$this->render($template, ["allCats" => $allCats, "allMessages" => $allMessages, "errors" => $errors, "title" => $title, "content" => $content]);
				}
			}
			else
			{
				$template = "membersSharingZone";
				$allCats = $this->scm->getAllCategories();
				$allMessages = $this->sim->getAllSharingItems();

				$this->render($template, ["allCats" => $allCats, "allMessages" => $allMessages]);
			}
		}
		else
		{
			$template = "connect";

			$token = $this->generateToken(20);
			$_SESSION["tokenRequiredForMemberConnection"] = $token;
	
			$this->render($template, ["token" => $token]);
		}
	}

	public function shareByCat($catId) : void
	{
		if(isset($_POST["action"]) && $_POST["action"] === "displaySharingMessage")
		{
			$shares = $this->sim->getSharingItemsByCatId($_POST["catId"]);
			foreach($shares as $key => $share)
			{
				$answers = $this->sam->getAllShareAnswersBySharingItemId($share["id"]);
				$share["answers"] = $answers;
				$sharesByCat[] = $share;
			}

			if(isset($sharesByCat) && $sharesByCat !== [])
			{
				$allCats = $this->scm->getAllCategories();
				$catName = $_POST["catName"];
				$template = "membersShareByCat";
	
				$this->render($template, ["sharesByCat" => $sharesByCat, "catName" => $catName, "allCats" => $allCats]);
			}
			else
			{
				$allCats = $this->scm->getAllCategories();
				$catName = $_POST["catName"];
				$errors[] = "aucun message dans la catégorie " . $catName . " pour l'instant";

				$template = "membersShareByCat";

				$this->render($template, ["errors" => $errors, "catName" => $catName, "allCats" => $allCats]);
 			}


		}
		else if (isset($_POST["action"]) && $_POST["action"] === "shareAnswer")
		{
			if(!isset($_POST["shareAnswerContent"]) || $_POST["shareAnswerContent"] === "")
			{
				$shares = $this->sim->getSharingItemsByCatId($_POST["catId"]);
				foreach($shares as $key => $share)
				{
					$answers = $this->sam->getAllShareAnswersBySharingItemId($share["id"]);
					$share["answers"] = $answers;
					$sharesByCat[] = $share;
				}
	
				$allCats = $this->scm->getAllCategories();
				$catName = $_POST["catName"];
				$errors[] = "attention a bien compléter ta réponse";
				$template = "membersShareByCat";
	
				$this->render($template, ["errors" => $errors, "sharesByCat" => $sharesByCat, "catName" => $catName, "allCats" => $allCats]);
			}
			else
			{
				$this->sam->createShareAnswer($_POST["shareId"], $_SESSION["user"]["id"], $_POST["shareAnswerContent"]);
				$validation = "Ta réponse a bien été prise en compte";
	
				$shares = $this->sim->getSharingItemsByCatId($_POST["catId"]);
				foreach($shares as $key => $share)
				{
					$answers = $this->sam->getAllShareAnswersBySharingItemId($share["id"]);
					$share["answers"] = $answers;
					$sharesByCat[] = $share;
				}
	
				$allCats = $this->scm->getAllCategories();
				$catName = $_POST["catName"];
				$validation = "ta réponse à bien été enregistrée";
				$template = "membersShareByCat";
	
				$this->render($template, ["validation" => $validation, "sharesByCat" => $sharesByCat, "catName" => $catName, "allCats" => $allCats]);
			}
		}
		else
		{
			//Sinon renvoie vers la connexion
			$template = "connect";

			$token = $this->generateToken(20);
			$_SESSION["tokenRequiredForMemberConnection"] = $token;
	
			$this->render($template, ["token" => $token]);
		}
	}
}