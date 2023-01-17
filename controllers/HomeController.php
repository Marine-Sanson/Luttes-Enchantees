<?php

Class HomeController extends AbstractController
{
	public function index() :void
	{
		//va chercher les events publics
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

		//Va chercher les chants du moment
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

		//Renvoie le tout vers la home
		$this->render($template, ["events" => $events, "songs" => $songs]);
	}
}