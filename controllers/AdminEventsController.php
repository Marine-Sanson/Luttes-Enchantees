<?php

Class AdminEventsController extends AbstractController
{
	public function index() :void
	{
		$template = "adminEvents";
		$cats = $this->em->getCats();

		if(isset($_POST["action"]) && $_POST["action"] === "newEvent")
		{
			// $tempPriv = trim($_POST["privateDetails"]);
			// $tempPub = trim($_POST["publicDetails"]);

			if($_POST["eventDate"] === "")
			{
				$errors[] = "veuillez selectionner une date";
			}
			else
			{
				$tempDate = $_POST["eventDate"];
				$explode = explode("-", $tempDate);
				$date = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
			}

			if(!isset($_POST["cat"]) || $_POST["cat"] === "")
			{
				$errors[] = "veuillez choisir une catégorie";
			}
			else
			{
				$eventCatId = intval($_POST["cat"]);

				if($_POST["privateDetails"] === "")
				{
					if($_POST["cat"] === "1")
					{
						$privateDetails = "Arrivée entre 9h30 et 10H - Début séance 10h, fin 13h et papotages rangement. 46 rue de lorient, locaux de l ASFAD en face stade rennais salle Angelina Gonidec. Amenez verres boissons... Enfants bienvenus";
					}
					else
					{
						$errors[] = "veuillez précisez les infos internes";
					}				
				}
				else
				{
					$privateDetails = $_POST["privateDetails"];
				}

				if($_POST["publicDetails"] === "")
				{
					if($_POST["cat"] === "1")
					{
						$publicDetails = "Répétition de 10h à 13h";
					}
					else
					{
						$publicDetails = $_POST["privateDetails"];
					}				
				}
				else
				{
					$publicDetails = $_POST["publicDetails"];
				}
			}

			if(!isset($_POST["status"]) || $_POST["status"] === "")
			{
				$errors[] = "Veuillez définir un statut";
			}
			else
			{
				$status = $_POST["status"];
			}


			if(!isset($errors) || $errors === [])
			{
				$newEvent = new Event(null, $date, $eventCatId, $privateDetails, $publicDetails, $status);
				$this->em->createEvent($newEvent);
	
				$validation = "Cette date a bien été enregistrée";
				$events = $this->em->getEvents();

				$this->render($template, ["cats" => $cats, "events" => $events, "validation" => $validation]);
			}
			else
			{
				if(!isset($tempDate))
				{
					$tempDate = "";
				}

				if(!isset($eventCatId))
				{
					$eventCatId = "";
				}

				if(!isset($status))
				{
					$status = "";
				}

				if(!isset($privateDetails))
				{
					$privateDetails = "";
				}

				if(!isset($publicDetails))
				{
					$publicDetails = "";
				}

				$event = [
					"date" => $tempDate,
					"cat" => $eventCatId,
					"status" => $status,
					"privateDetails" => $privateDetails,
					"publicDetails" => $publicDetails
				];
				$events = $this->em->getEvents();

				$this->render($template, ["cats" => $cats, "event" => $event, "events" => $events, "errors" => $errors]);
			}

		}
		else if(!isset($_POST["action"]) || $_POST["action"] === "")
		{
			$events = $this->em->getEvents();

			$template = "adminEvents";
			$this->render($template, ["cats" => $cats, "events" => $events]);
		}
	}

	public function updateEvent(int $id) : void
	{
		$id = intval($_POST["eventId"]);
		$event = $this->em->getEventById($id);
		var_dump($event);

		$template = "adminUpdateEvent";
		$this->render($template, ["event" => $event]);
	}
}