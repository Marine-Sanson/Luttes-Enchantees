<?php

Class MembersEventsController extends AbstractController
{
	public function index() :void
	{
		$template = "membersEvents";

		$events = $this->em->getEvents();
		$cats = $this->em->getCats();

		$this->render($template, ["cats" => $cats, "events" => $events]);
	}

	public function eventDetail() : void
	{
		if(isset($_POST) && $_POST["action"] === "eventDetail")
		{
			$id = intval($_POST["eventId"]);
			$event = $this->em->getEventById($id);
			$catId = $event->getEventCatId();
	
			$cat = $this->em->getCatById($catId);

			$template = "eventDetail";
			$this->render($template, ["event" => $event, "cat" => $cat]);
		}
		else
		{
			$events = $this->em->getEvents();
			$cats = $this->em->getCats();

			$template = "membersEvents";
			$this->render($template, ["cats" => $cats, "events" => $events]);
		}	
	}
}