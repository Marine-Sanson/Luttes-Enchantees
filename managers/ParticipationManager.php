<?php

class ParticipationManager extends AbstractManager
{
	public function createParticipation(int $event_id, int $user_id, string $status) : void
	{
		$query = $this->db->prepare('INSERT INTO participations (event_id, user_id, status)
		VALUES (:event_id, :user_id, :status)');
		$parameters = [
			'event_id' => $event_id,
			'user_id' => $user_id,
			'status' => $status
			];
		$query->execute($parameters);
	}

	public function getParticipationData(int $event_id, int $user_id) : array
	{
		$query = $this->db->prepare('SELECT * FROM participations WHERE event_id = :event_id AND user_id = :user_id');
		$parameters = [
                  'event_id' => $event_id,
			'user_id' => $user_id
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$part = $result["name"];

		return $part;
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
