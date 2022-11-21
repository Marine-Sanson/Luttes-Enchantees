<?php

class ChatItem
{
    private ?int $id;
    private int $userId;
    private string $title;
    private string $message;
    private DateTime $date;

    function __construct(?int $id, int $userId, string $title, string $message, DateTime $date)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->message = $message;
        $this->date = $date;
    }

    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function getUserId() : ?int
    {
        return $this->userId;
    }
    
    public function setUserId(?int $userId) : void
    {
        $this->userId = $userId;
    }

    public function getTitle() : string
    {
        return $this->title;
    }
    
    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getMessage() : string
    {
        return $this->message;
    }
    
    public function setMessage(string $message) : void
    {
        $this->message = $message;
    }

    public function getDate() : DateTime
    {
        return $this->date;
    }
    
    public function setDate(DateTime $date) : void
    {
        $this->date = $date;
    }

}