<?php

Class ConnectController extends AbstractController
{
	public function index() : void
	{
		$template = "connect";

		$this->render($template);
	}

	public function checkConnection() : void
	{
		if (isset($_POST) && $_POST["action"] === "checkConnection")
		{
			$errors = [];

			$email = $_POST["email"];
			$password = $_POST["password"];

			if ($email === "" || $password === "")
			{
				$errors[] = "Veuillez vous connecter";
				$template = "connect";

				$this->render($template, ["errors" => $errors]);
			}
			else
			{
				$user = $this->um->connectAdmin($email);

				if(isset($user) && !empty($user) && $user !== [])
				{
					$_SESSION["connectUser"] = false;
					if ($email !== $user["email"] || !password_verify($password, $user["password"]))
					{
						$errors[] = "identifiant ou mot de passe incorrect";
						$template = "connect";

						$this->render($template, ["errors" => $errors]);
					}
					else if($email === $user["email"] && password_verify($password, $user["password"]))
					{
						$_SESSION["connectUser"] = true;
						$_SESSION["user"] = [
							"id" => $user["id"],
							"name" => $user["name"],
							"role" => $user["role"]
						];

						$allEvents = $this->em->getEvents();
						$events = [];

						foreach($allEvents as $key => $event)
						{
							$cat = $this->em->getCatById($event["event_cat_id"]);
							$events[] = [
								"id" => $event["id"],
								"date" => $event["date"],
								"event_cat_id" => $event["event_cat_id"],
								"cat" => $cat,
								"private_details" => $event["private_details"]
							];
						}

						$template = "membersHome";

						$this->render($template, ["errors" => $errors, "events" => $events]);
					}
					else
					{
						$template = "connect";
						$errors[] = "Les identifiants ne sont pas valides";

						$this->render($template, ["errors" => $errors]);
					}
				}
				else
				{
					$template = "connect";
					$errors[] = "Les identifiants ne sont pas valides";

					$this->render($template, ["errors" => $errors]);
				}
			}
		}
		else
		{
			$template = "connect";

			$this->render($template);
		}
	}
}