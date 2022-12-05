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

	public function getCatById(int $id) : string
	{
		$query = $this->db->prepare('SELECT name FROM events_categories WHERE id = :id');
		$parameters = [
			'id' => $id
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$cat = $result[0]["name"];

		return $cat;
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
		$query = $this->db->prepare('SELECT * FROM events WHERE id = :id');
		$parameters = [
			'id' => $id
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$event = new Event($result[0]["id"], $result[0]["date"], $result[0]["event_cat_id"], $result[0]["private_details"], $result[0]["public_details"], $result[0]["status"]);

		return $event;
	}

	public function updatedEvent(Event $event) : void
	{
		var_dump($event);
		var_dump($event->getId());
		var_dump($event->getDate());
		var_dump($event->getEventCatId());
		var_dump($event->getPrivateDetails());
		var_dump($event->getPublicDetails());
		var_dump($event->getStatus());

		$tempStatus = $event->getStatus();

		if(!$tempStatus)
		{
			$status = 0;
		}
		else if($tempStatus)
		{
			$status = 1;
		}

		var_dump($status);


		$query = $this->db->prepare('UPDATE events SET date = :date, event_cat_id = :event_cat_id, private_details = :private_details, public_details = :public_details, status = :status WHERE id = :id');
		$parameters = [
			'id' => $event->getId(),
			'date' => $event->getDate(),
			'event_cat_id' => $event->getEventCatId(),
			'private_details' => $event->getPrivateDetails(),
			'public_details' => $event->getPublicDetails(),
			'status' => $status
			];
		$query->execute($parameters);
	}
}
