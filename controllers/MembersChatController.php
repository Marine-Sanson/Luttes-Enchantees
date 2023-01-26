<?php

Class MembersChatController extends AbstractController
{
	public function index() : void
	{
		if($_SESSION["connectUser"])
		{
			//Si POST action est isset ou vide, va chercher les messages et leurs réponses
			if(!isset($_POST["action"]) || $_POST["action"] === "")
			{
				$template = "membersChat";
				$chats = $this->cim->getAllChatItems();
				foreach($chats as $key => $chat)
				{
					$answers = $this->cam->getAllChatAnswers($chat["id"]);
					$chat["answers"] = $answers;
					$allChats[] = $chat;
				}
	
				$this->render($template, ["allChats" => $allChats]);
			}
			else if(isset($_POST["action"]) && $_POST["action"] === "newChat")
			{
				//Sinon si l'action est "newChat" vérifie que le formulaire est rempli et sinon rempli le tableau d'erreurs
				if(!isset($_POST["title"]) || $_POST["title"] === "")
				{
					$errors[] = "N'oublie pas le titre de ton message";
				}
	
				if(!isset($_POST["content"]) || $_POST["content"] === "")
				{
					$errors[] = "Entre un message";
				}
	
				//Si le tableau d'erreurs est vide crée le nouveau message, puis va chercher les messages et leurs réponses
				if(!isset($errors) || $errors === [])
				{
					$this->cim->createChatItem(intval($_SESSION["user"]["id"]), $_POST["title"], $_POST["content"]);
					$template = "membersChat";
					$chats = $this->cim->getAllChatItems();
					foreach($chats as $key => $chat)
					{
						$answers = $this->cam->getAllChatAnswers($chat["id"]);
						$chat["answers"] = $answers;
						$allChats[] = $chat;
					}
					$_POST["title"] = "";
					$_POST["content"] = "";
					$validation = "Ton message a bien été pris en compte";
			
					$this->render($template, ["allChats" => $allChats, "validation" => $validation]);
				}
				else
				{
					//Sinon redirige vers "membersChat"
					$template = "membersChat";
					$chats = $this->cim->getAllChatItems();
					foreach($chats as $key => $chat)
					{
						$answers = $this->cam->getAllChatAnswers($chat["id"]);
						$chat["answers"] = $answers;
						$allChats[] = $chat;
					}
			
					$this->render($template, ["allChats" => $allChats, "errors" => $errors]);
				}
			}
			//Sinon si l'action est "chatAnswer"
			else if(isset($_POST["action"]) && $_POST["action"] === "chatAnswer")
			{
				//Vérifie le formulaire
				if(!isset($_POST["chatAnswerMessage"]) || $_POST["chatAnswerMessage"] === "")
				{
					$errors[] = "Attention tu essayes d'envoyer une réponse vide";

					$template = "membersChat";
					$chats = $this->cim->getAllChatItems();
					foreach($chats as $key => $chat)
					{
						$answers = $this->cam->getAllChatAnswers($chat["id"]);
						$chat["answers"] = $answers;
						$allChats[] = $chat;
					}			
					$this->render($template, ["allChats" => $allChats, "errors" => $errors]);
				}
				//Sinon crée la réponse
				else if(isset($_POST["chatAnswerMessage"]) && $_POST["chatAnswerMessage"] !== "")
				{
					$this->cam->createChatAnswer($_POST["chatId"], $_SESSION["user"]["id"], $_POST["chatAnswerMessage"]);

					$template = "membersChat";
					$chats = $this->cim->getAllChatItems();
					foreach($chats as $key => $chat)
					{
						$answers = $this->cam->getAllChatAnswers($chat["id"]);
						$chat["answers"] = $answers;
						$allChats[] = $chat;
					}					$validation = "Ta réponse a bien été prise en compte";

					$this->render($template, ["allChats" => $allChats, "validation" => $validation]);
				}
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
}