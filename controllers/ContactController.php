<?php

Class ContactController extends AbstractController
{
	public function index() :void
	{
		$template = "contact";

		$token = $this->generateToken(25);
		$_SESSION["tokenRequiredForSendingAnEmail"] = $token;

		$this->render($template, ["token" => $token]);
	}

	public function sendMail() : void
	{
		if(isset($_POST["token"]) && $_POST["token"] === $_SESSION["tokenRequiredForSendingAnEmail"])
		{
			if(isset($_POST["action"]) && $_POST["action"] === "newMail")
			{
				$template = "contact";

				if($_POST["podMel"] !== "")
				{
					$errors[] = "il y a eu un problème, veuillez recommencer";
				}

				if($_POST["control"] !== "5")
				{
					$errors[] = "merci de répondre à la question, en chiffre";
				}

				if($_POST["mailAdress"] === "")
				{
					$errors[] = "Veuillez renseigner votre adresse mail";
				}

				if($_POST["mailObject"] === "")
				{
					$errors[] = "Veuillez renseigner l'objet";
				}

				if($_POST["mailContent"] === "")
				{
					$errors[] = "Veuillez remplir le champ contenu";
				}

				if(!isset($errors) || $errors === [])
				{
					$to = "marine_sanson@yahoo.fr";
					$mailObject = $this->clean_input($_POST["mailObject"]);
					$subject = "Luttes Enchantées - " . $mailObject;
					$mailContent = $this->clean_input($_POST["mailContent"]);
					$mess = $mailContent;
					$message = wordwrap($mess, 70, "/r/n");

					$mail = $_POST["mailAdress"];
					$headers = "De : " . $mail;

					$newContact = $this->cm->createNewContact($mail, $mailObject, $mailContent);

					// $mail = mail($to, $subject, $message, $headers);

					// if($mail)
					// {
						$validation = "votre mail a bien été envoyé";

						$token = $this->generateToken(25);
						$_SESSION["tokenRequiredForSendingAnEmail"] = $token;

						$this->render($template, ["validation" => $validation, "token" => $token]);
					// }
					// else
					// {
					// 	$errors[] = "il y a eu un problème, merci de recommencer";

					// 	$this->render($template, ["errors" => $errors]);
					// }
				}
				else
				{
					$token = $this->generateToken(25);
					$_SESSION["tokenRequiredForSendingAnEmail"] = $token;

					$this->render($template, ["errors" => $errors, "token" => $token]);
				}
			}
		}
		else
		{
			$template = "contact";

			$token = $this->generateToken(25);
			$_SESSION["tokenRequiredForSendingAnEmail"] = $token;
	
			$errors[] = "il y a eu un problème, merci de recommencer";

			$this->render($template, ["errors" => $errors, "token" => $token]);
		}
	}
}