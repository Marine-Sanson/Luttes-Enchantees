<?php

class Text
{
    private ?int $id;
    private int $songId;
    private string $originalName;
    private string $filelName;
    private string $filelType;
    private string $url;
    private string $alt;

    function __construct(?int $id, int $songId, string $originalName, string $filelName, string $filelType, string $url, string $alt)
    {
        $this->id = $id;
        $this->songId = $songId;
        $this->originalName = $originalName;
        $this->filelName = $filelName;
        $this->filelType = $filelType;
        $this->url = $url;
        $this->alt = $alt;
    }

    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function getSongId() : int
    {
        return $this->songId;
    }
    
    public function setSongId(int $songId) : void
    {
        $this->songId = $songId;
    }

    public function getOriginalName() : string
    {
        return $this->originalName;
    }
    
    public function setOriginalName(string $originalName) : void
    {
        $this->originalName = $originalName;
    }

    public function getFilelName() : string
    {
        return $this->filelName;
    }
    
    public function setFilelName(string $filelName) : void
    {
        $this->filelName = $filelName;
    }

    public function getFilelType() : string
    {
        return $this->filelType;
    }
    
    public function setFilelType(string $filelType) : void
    {
        $this->filelType = $filelType;
    }

    public function getUrl() : string
    {
        return $this->url;
    }
    
    public function setUrl(string $url) : void
    {
        $this->url = $url;
    }

    public function getAlt() : string
    {
        return $this->alt;
    }
    
    public function setAlt(string $alt) : void
    {
        $this->alt = $alt;
    }

}