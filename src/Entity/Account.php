<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Entity;

use DateTime;

class Account
{   
    
    protected string $uuid = 'ea49ab67-14e3-4a45-8691-4a6adcd79477';
    
    protected string $name = 'Guest';
    
    protected ?string $email = null;
    
    protected ?string $password = null;

    protected string $passwordHash  = '$2y$10$kbUGUT68WAraS/fa5JNe/OqTlkHNOalgNU5ggn9qghggOgsxDKScW';
    
    protected \DateTime $registrationTime;
    
    protected \DateTime $lastActive;
    
    
    public function __construct() 
    {
        $this->registrationTime = new DateTime();
        $this->lastActive = new DateTime();
    }


    public function getUuid(): string
    {
        return $this->uuid;
    }
    
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
    
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
    
    public function setPasswordHash(string $passwordHash): self
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function getRegistrationTime(): DateTime
    {
        return $this->registrationTime;
    }
    
    public function setRegistrationTime(DateTime $registrationTime): self
    {
        $this->registrationTime = $registrationTime;
        return $this;
    }
       
    public function getLastActive(): DateTime
    {
        return $this->lastActive;
    }                    

    public function setLastActive(DateTime $lastActive): self
    {
        $this->lastActive = $lastActive;
        return $this;
    }
}
