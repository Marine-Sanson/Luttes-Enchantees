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

	public function getParticipationStatus(int $event_id, int $user_id) : string
	{
		$query = $this->db->prepare('SELECT * FROM participations WHERE event_id = :event_id AND user_id = :user_id');
		$parameters = [
                  'event_id' => $event_id,
			'user_id' => $user_id
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$part = $result[0]["status"];

		return $part;
	}

	public function countParticipation(int $eventId, string $status) : int
	{
		$query = $this->db->prepare('SELECT COUNT(*) FROM participations WHERE event_id =:event_id AND status = :status');
		$parameters = [
			'event_id' => $eventId,
			'status' => $status
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		$count = $result[0]["COUNT(*)"];

		return $count;
	}

	public function getMembersPartByEventId(int $eventId) : array
	{
		$query = $this->db->prepare('SELECT participations.user_id, participations.status, users.name as user_name FROM participations JOIN users ON participations.user_id = users.id WHERE event_id = :event_id ORDER BY participations.status');
		$parameters = [
                  'event_id' => $eventId
			];
		$query->execute($parameters);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}

	public function updateParticipation(int $userId, int $eventId, string $participation) : void
	{
		$query = $this->db->prepare('UPDATE participations SET status = :status WHERE user_id = :user_id AND event_id = :event_id');
		$parameters = [
			'user_id' => $userId,
			'event_id' => $eventId,
			'status' => $participation
			];
		$query->execute($parameters);
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


}
