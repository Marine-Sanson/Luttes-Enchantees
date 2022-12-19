<?php

Class MembersHomeController extends AbstractController
{
	public function index() : void
	{
		if ($_SESSION["connectUser"] && isset($_SESSION["user"]) && $_SESSION["user"] !== [])
		{
			if (isset($_POST["action"]) && $_POST["action"] === "setParticipation")
			{
				$this->pm->updateParticipation($_POST["userId"], $_POST["eventId"], $_POST["participation"]);
			}
			
			$allEvents = $this->em->getEvents();
			$events = [];

			foreach ($allEvents as $key => $event) {
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
		else
		{
			$template = "connect";

			$this->render($template);
		}
	}
}