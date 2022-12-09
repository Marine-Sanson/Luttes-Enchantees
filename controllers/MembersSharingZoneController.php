<?php

Class MembersSharingZoneController extends AbstractController
{
	public function index() : void
	{
		if($_SESSION["connectUser"])
		{
			$template = "membersSharingZone";
			$allCats = $this->scm->getAllCategories();
			$allMessages = $this->sim->getAllSharingItems();

			$this->render($template, ["allCats" => $allCats, "allMessages" => $allMessages]);
		}
		else
		{
			$template = "connect";

			$this->render($template);
		}
	}

	public function newShare() : void
	{
		if(isset($_POST) && $_POST["action"] === "newSharingMessage")
		{
			var_dump("entre dans action = newSharingMessage");
			$template = "newShare";
			$allCats = $this->scm->getAllCategories();
	
			$this->render($template, ["allCats" => $allCats]);
		}
		else if(isset($_POST) && $_POST["action"] === "newShare")
		{
			var_dump("entre dans action = newShare");

			$errors = [];
			if(!isset($_POST["title"]) || $_POST["title"] === "" )
			{
				var_dump("entre dans title = vide");
				$errors[] = "N'oublie pas de mettre un titre";
			}

			if(!isset($_POST["content"]) || $_POST["content"] === "")
			{
				var_dump("entre dans content = vide");

				$errors[] = "N'oublie pas de mettre un contenu";
			}

			if($errors === [])
			{
				var_dump("entre dans errors = vide");
				$userId = $_SESSION["user"]["id"];
				$title = $_POST["title"];
				$content = $_POST["content"];
				$categoryId = $_POST["catId"];

				$this->sim->createSahringItem($userId, $title, $content, $categoryId);
				$validation = "Ton message a bien été créé";

				$template = "newShare";
				$allCats = $this->scm->getAllCategories();
		
				$this->render($template, ["allCats" => $allCats, "validation" => $validation]);
			}
			else if($errors !== [])
			{
				var_dump("entre dans errors != vide");

				$template = "newShare";
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
			var_dump("entre dans le dernier else");

			$template = "membersSharingZone";
			$allCats = $this->scm->getAllCategories();
			$allMessages = $this->sim->getAllSharingItems();

			$this->render($template, ["allCats" => $allCats, "allMessages" => $allMessages]);
		}
}
}