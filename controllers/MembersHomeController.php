<?php

Class MembersHomeController extends AbstractController
{
	public function index() :void
	{
		if($_SESSION["connectUser"] && isset($_SESSION["user"]) && $_SESSION["user"] !== [])
		{
			var_dump($_POST["eventId"]);
			var_dump($_POST["userId"]);

			if(isset($_POST) && $_POST["action"] === "setParticipation")
			{
				$part = $this->pm->getParticipationData($_POST["eventId"], $_POST["userId"]);

				var_dump($part);

			}
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
	
			$template = "membersHome";
	
			$this->render($template);
		}
	}
}