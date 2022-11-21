<?php

class User
{
    private ?int $id;
    private string $email;
    private string $name;
    private string $password;
    private string $role;

    function __construct(?int $id, string $email, string $name, string $password, string $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function getEmail() : string
    {
        return $this->email;
    }
    
    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function getName() : string
    {
        return $this->name;
    }
    
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getPassword() : string
    {
        return $this->password;
    }
    
    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function getRole() : string
    {
        return $this->role;
    }
    
    public function setRole(string $role) : void
    {
        $this->role = $role;
    }

}