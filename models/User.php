<?php

class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $tel;
    private string $password;
    private string $role;
    private int $agreement;

    function __construct(?int $id, string $name, string $email, string $tel, string $password, string $role, int $agreement)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->tel = $tel;
        $this->password = $password;
        $this->role = $role;
        $this->agreement = $agreement;
    }

    public function getId() : ?int
    {
        return $this->id;
    }
    
    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function getName() : string
    {
        return $this->name;
    }
    
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getEmail() : string
    {
        return $this->email;
    }
    
    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function getTel() : string
    {
        return $this->tel;
    }
    
    public function setTel(string $tel) : void
    {
        $this->tel = $tel;
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

    public function getAgreement() : ?int
    {
        return $this->agreement;
    }
    
    public function setAgreement(?int $agreement) : void
    {
        $this->agreement = $agreement;
    }
}