<?php

Class ContactController extends AbstractController
{
	public function index() :void
	{
		$template = "contact";

		$this->render($template);

	}

	public function sendMail() : void
	{
		if(isset($_POST["action"]) && $_POST["action"] === "newMail")
		{
			$template = "contact";

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
				$subject = "Luttes Enchantées - " . $_POST["mailObject"];
				$mess = $_POST["mailContent"];
				$message = wordwrap($mess, 70, "/r/n");
				$headers = "De : " . $_POST["mailAdress"];

				$mail = mail($to, $subject, $message, $headers);
				var_dump($mail);

				if($mail)
				{
					$validation = "votre mail a bien été envoyé";

					$this->render($template, ["validation" => $validation]);
				}
				else
				{
					$errors[] = "il y a eu un problème, merci de recommencer";

					$this->render($template, ["errors" => $errors]);
				}
			}
			else
			{
				$this->render($template, ["errors" => $errors]);
			}

		}
	}
}