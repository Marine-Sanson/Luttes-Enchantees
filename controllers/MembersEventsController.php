<?php

Class MembersEventsController extends AbstractController
{
	public function index() :void
	{
		$template = "membersEvents";

		$allEvents = $this->em->getEvents();
		$events = [];
		foreach($allEvents as $key => $event)
		{
			$oui = $this->pm->countParticipation($event["id"], "Oui");
			$non = $this->pm->countParticipation($event["id"], "Non");
			$nsp = $this->pm->countParticipation($event["id"], "Je ne sais pas");
			$nonrep = $this->pm->countParticipation($event["id"], "Non répondu");

			$events[] = [
				"id" => $event["id"],
				"date" => $event["date"],
				"event_cat_id" => $event["event_cat_id"],
				"private_details" => $event["private_details"],
				"public_details" => $event["public_details"],
				"status" => $event["status"],
				"oui" => $oui,
				"non" => $non,
				"nsp" => $nsp,
				"nonrep" => $nonrep
			];
		}
		$cats = $this->em->getCats();

		$this->render($template, ["cats" => $cats, "events" => $events]);
	}

	public function eventDetail(): void
	{
		if ($_SESSION["connectUser"]) {
			if (isset($_POST) && $_POST["action"] === "membersEventDetail") {
				$id = intval($_POST["eventId"]);
				$event = $this->em->getEventById($id);
				$catId = $event->getEventCatId();
				$parts = $this->pm->getMembersPartByEventId($id);

				$oui = $this->pm->countParticipation($id, "Oui");
				$non = $this->pm->countParticipation($id, "Non");
				$nsp = $this->pm->countParticipation($id, "Je ne sais pas");
				$nonrep = $this->pm->countParticipation($id, "Non répondu");

				$count = [
					"oui" => $oui,
					"non" => $non,
					"nsp" => $nsp,
					"nonrep" => $nonrep
				];

				$cat = $this->em->getCatById($catId);

				$template = "membersEventDetail";
				$this->render($template, ["event" => $event, "parts" => $parts, "count" => $count, "cat" => $cat]);
			} else {
				$events = $this->em->getEvents();
				$cats = $this->em->getCats();

				$template = "membersEvents";
				$this->render($template, ["cats" => $cats, "events" => $events]);
			}
		} else {
			$template = "connect";

			$this->render($template);
		}
	}
}