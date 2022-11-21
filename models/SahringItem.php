<?php

class SahringItem
{
    private ?int $id;
    private int $userId;
    private string $title;
    private string $content;
    private int $categoryId;
    private DateTime $date;

    function __construct(?int $id, int $userId, string $title, string $content, int $categoryId, DateTime $date)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->categoryId = $categoryId;
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

    public function getContent() : string
    {
        return $this->content;
    }
    
    public function setContent(string $content) : void
    {
        $this->content = $content;
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