<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Controller;
use Exdrals\Bugebo\Entity\Account as AccountEntity;
use Exdrals\Excidia\Component\Interfaces\Database;


class Account 
{

    protected Database $database;
    
    public function __construct(Database $database) 
    {
        $this->database = $database;
    }
    
    public function createOrUpdate(Account $user)
    {
        
    }
    
    public function delete(Account $user) 
    {
        
    }
    
    public function findeByUUID(string $UUID) : ?AccountEntity
    {
        $sql = 'SELECT `uuid`, `name`, `email`, `passwordHash`, `registrationTime`, `lastActiv` FROM `ex_accounts` WHERE `uuid`=:value';     
        return $this->findBy($sql, $UUID);
    }
    
    public function findeByName(string $name) : ?AccountEntity
    {        
        $sql = 'SELECT `uuid`, `name`, `email`, `passwordHash`, `registrationTime`, `lastActiv` FROM `ex_accounts` WHERE `name`=:value';     
        return $this->findBy($sql, $name);        
    }
    
    protected function findBy(string $sql, string $value): ?AccountEntity
    {        
        $stmt = $this->database->prepare($sql);        
        $stmt->execute([':value' => $value]);
        $result = $stmt->fetch();        
        if (!$result)
        {
            return null;
        }
        $account = new AccountEntity;
        $account->setName($result['name']);
        $account->setEmail($result['email']);
        $account->setPasswordHash($result['passwordHash']);
        $account->setRegistrationTime(new \DateTime($result['registrationTime']));
        $account->setLastActiv(new \DateTime($result['lastActiv']));        
        return $account;
    }    
}
