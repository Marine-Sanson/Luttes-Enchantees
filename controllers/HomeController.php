<?php

Class HomeController extends AbstractController
{
	public function index() :void
	{
		$template = "home";

		$allEvents = $this->em->getPublicEvents();
		$events = [];

		foreach ($allEvents as $key => $event)
		{
			$cat = $this->em->getCatById($event["event_cat_id"]);
			$events[] = [
				"id" => $event["id"],
				"date" => $event["date"],
				"event_cat_id" => $event["event_cat_id"],
				"cat" => $cat,
				"public_details" => $event["public_details"]
			];
		}

		$allSongs = $this->sm->getCurrentSongs();
		$songs = [];

		foreach ($allSongs as $key => $song)
		{
			$songs[] = [
				"id" => $song["id"],
				"title" => $song["title"],
				"description" => $song["description"],
				"urlVideo" => $song["url_video"]
			];
		}

		$template = "home";

		$this->render($template, ["events" => $events, "songs" => $songs]);
	}
}