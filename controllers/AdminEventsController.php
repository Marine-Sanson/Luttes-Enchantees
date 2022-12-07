<?php

Class AdminEventsController extends AbstractController
{
	public function index() :void
	{
		if ($_SESSION["connectUser"] && $_SESSION["user"]["role"] === "admin") {
			$template = "adminEvents";
			$cats = $this->em->getCats();

			if (isset($_POST["action"]) && $_POST["action"] === "newEvent") {
				// $tempPriv = trim($_POST["privateDetails"]);
				// $tempPub = trim($_POST["publicDetails"]);

				if ($_POST["eventDate"] === "") {
					$errors[] = "veuillez selectionner une date";
				} else {
					$tempDate = $_POST["eventDate"];
					$explode = explode("-", $tempDate);
					$date = $explode[2] . "-" . $explode[1] . "-" . $explode[0];
				}

				if (!isset($_POST["cat"]) || $_POST["cat"] === "") {
					$errors[] = "veuillez choisir une catégorie";
				} else {
					$eventCatId = intval($_POST["cat"]);

					if ($_POST["privateDetails"] === "") {
						if ($_POST["cat"] === "1") {
							$privateDetails = "Arrivée entre 9h30 et 10H - Début séance 10h, fin 13h et papotages rangement. 46 rue de lorient, locaux de l ASFAD en face stade rennais salle Angelina Gonidec. Amenez verres boissons... Enfants bienvenus";
						} else {
							$errors[] = "veuillez précisez les infos internes";
						}
					} else {
						$privateDetails = $_POST["privateDetails"];
					}

					if ($_POST["publicDetails"] === "") {
						if ($_POST["cat"] === "1") {
							$publicDetails = "Répétition de 10h à 13h";
						} else {
							$publicDetails = $_POST["privateDetails"];
						}
					} else {
						$publicDetails = $_POST["publicDetails"];
					}
				}

				if (!isset($_POST["status"]) || $_POST["status"] === "") {
					$errors[] = "Veuillez définir un statut";
				} else {
					$status = $_POST["status"];
				}


				if (!isset($errors) || $errors === []) {
					$newEvent = new Event(null, $date, $eventCatId, $privateDetails, $publicDetails, $status);
					$eventId = $this->em->createEvent($newEvent);
					$users = $this->um->getAllUsersId();
					$status = "Non répondu";

					foreach ($users as $key => $user) {
						$this->pm->createParticipation($eventId, $user["id"], $status);
					}

					$validation = "Cette date a bien été enregistrée";
					$events = $this->em->getEvents();

					$this->render($template, ["cats" => $cats, "events" => $events, "validation" => $validation]);
				} else {
					if (!isset($tempDate)) {
						$tempDate = "";
					}

					if (!isset($eventCatId)) {
						$eventCatId = "";
					}

					if (!isset($status)) {
						$status = "";
					}

					if (!isset($privateDetails)) {
						$privateDetails = "";
					}

					if (!isset($publicDetails)) {
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

			} else if (!isset($_POST["action"]) || $_POST["action"] === "") {
				$events = $this->em->getEvents();

				$template = "adminEvents";
				$this->render($template, ["cats" => $cats, "events" => $events]);
			}
		}
		else
		{
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

	public function updateEvent() : void
	{
		if(isset($_POST) && $_POST["action"] === "displayUpdateEvent")
		{
			$id = intval($_POST["eventId"]);
			$event = $this->em->getEventById($id);
			$catId = $event->getEventCatId();
	
			$cat = $this->em->getCatById($catId);
			$cats = $this->em->getCats();

			$validation = "cet évenement à bien été modifé";
			$template = "adminUpdateEvent";
			$this->render($template, ["event" => $event, "validation" => $validation, "cat" => $cat, "cats" => $cats]);
		}
		else if(isset($_POST) && $_POST["action"] === "updateEvent")
		{
			$id = intval($_POST["eventId"]);

			$tempDate = explode("-", $_POST["date"]);
			$date = $tempDate[2] . "-" . $tempDate[1] . "-" . $tempDate[0];

			$updatedEvent = new Event($_POST["eventId"], $date, $_POST["cat"], $_POST["privateDetails"], $_POST["publicDetails"], $_POST["status"]);

			$this->em->updatedEvent($updatedEvent);

			$event = $this->em->getEventById($id);
			$catId = $event->getEventCatId();
			$cat = $this->em->getCatById($catId);
			$cats = $this->em->getCats();
		
			$template = "adminUpdateEvent";
			$this->render($template, ["event" => $event, "cat" => $cat, "cats" => $cats]);
		}
		else
		{
			$events = $this->em->getEvents();
			$cats = $this->em->getCats();

			$template = "adminEvents";
			$this->render($template, ["cats" => $cats, "events" => $events]);
		}
	}
}