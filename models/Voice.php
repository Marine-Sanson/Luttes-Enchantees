<?php

class Voice
{
    private ?int $id;
    private int $songId;
    private string $voiceType;
    private string $originalName;
    private string $fileName;
    private string $fileType;
    private string $url;

    function __construct(?int $id, int $songId, string $voiceType, string $originalName, string $fileName, string $fileType, string $url)
    {
        $this->id = $id;
        $this->songId = $songId;
        $this->voiceType = $voiceType;
        $this->originalName = $originalName;
        $this->fileName = $fileName;
        $this->fileType = $fileType;
        $this->url = $url;
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

    public function getVoiceType() : string
    {
        return $this->voiceType;
    }
    
    public function setVoiceType(string $voiceType) : void
    {
        $this->voiceType = $voiceType;
    }

    public function getOriginalName() : string
    {
        return $this->originalName;
    }
    
    public function setOriginalName(string $originalName) : void
    {
        $this->originalName = $originalName;
    }

    public function getFileName() : string
    {
        return $this->fileName;
    }
    
    public function setFileName(string $fileName) : void
    {
        $this->fileName = $fileName;
    }

    public function getFileType() : string
    {
        return $this->fileType;
    }
    
    public function setFileType(string $fileType) : void
    {
        $this->fileType = $fileType;
    }

    public function getUrl() : string
    {
        return $this->url;
    }
    
    public function setUrl(string $url) : void
    {
        $this->url = $url;
    }

}