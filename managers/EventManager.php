<?php

class EventManager extends AbstractManager
{
	public function createEvent(Event $event) : void
	{
		$query = $this->db->prepare('INSERT INTO events (date, event_cat_id, private_details, public_details, status)
		VALUES (:date, :event_cat_id, :private_details, :public_details, :status)');
		$parameters = [
			'date' => $event->getDate(),
			'event_cat_id' => $event->getEventCatId(),
			'private_details' => $event->getPrivateDetails(),
			'public_details' => $event->getPublicDetails(),
			'status' => $event->getStatus()
			];
		$query->execute($parameters);
	}

	public function getCats() : array
	{
		$query = $this->db->prepare('SELECT * FROM events_categories');
		$query->execute();
		$cats = $query->fetchAll(PDO::FETCH_ASSOC);

		return $cats;
	}

	public function getEvents() : array
	{
		$query = $this->db->prepare('SELECT * FROM events');
		$query->execute();
		$events = $query->fetchAll(PDO::FETCH_ASSOC);

		return $events;
	}

	public function getEventById(int $id) : Event
	{
		$query = $this->db->prepare('SELECT * FROM events WHERE "id" = :id');
		$parameters = [
			'id' => $id
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		$event = new Event($result["id"], $result["date"], $result["eventCatId"], $result["privateDetails"], $result["publicDetails"], $result["publicDetails"]);

		return $event;
	}
}
