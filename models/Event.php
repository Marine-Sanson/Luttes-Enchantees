<?php

class Event
{
	private ?int $id;
	private string $date;
	private int $eventCatId;
	private string $privateDetails;
	private string $publicDetails;
	private bool $status;

	function __construct(?int $id, string $date, int $eventCatId, string $privateDetails, string $publicDetails, bool $status)
	{
		$this->id = $id;
		$this->date = $date;
		$this->eventCatId = $eventCatId;
		$this->privateDetails = $privateDetails;
		$this->publicDetails = $publicDetails;
		$this->status = $status; 
	}

	public function getId() : ?int
	{
		return $this->id;
	}
	
	public function setId(?int $id) : void
	{
		$this->id = $id;
	}

	public function getDate() : string
	{
		return $this->date;
	}
	
	public function setDate(string $date) : void
	{
		$this->date = $date;
	}

	public function getEventCatId() : ?int
	{
		return $this->eventCatId;
	}
	
	public function setEventCatId(?int $eventCatId) : void
	{
		$this->eventCatId = $eventCatId;
	}


	public function getPrivateDetails() : string
	{
		return $this->privateDetails;
	}
	
	public function setPrivateDetails(string $privateDetails) : void
	{
		$this->privateDetails = $privateDetails;
	}

	public function getPublicDetails() : string
	{
		return $this->publicDetails;
	}
	
	public function setPublicDetails(string $publicDetails) : void
	{
		$this->publicDetails = $publicDetails;
	}

		public function getStatus() : bool
	{
		return $this->status;
	}
	
	public function setStatus(bool $status) : void
	{
		$this->status = $status;
	}

}