<?php

Class MembersChatController extends AbstractController
{
	public function index() : void
	{
		if($_SESSION["connectUser"])
		{
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
				if(!isset($_POST["title"]) || $_POST["title"] === "")
				{
					$errors[] = "N'oublie pas le titre de ton message";
				}
	
				if(!isset($_POST["content"]) || $_POST["content"] === "")
				{
					$errors[] = "Entre un message";
				}
	
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
			else if(isset($_POST["action"]) && $_POST["action"] === "chatAnswer")
			{
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
	}

}