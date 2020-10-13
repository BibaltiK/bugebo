<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Repository\PDO;
use Exdrals\Bugebo\Entity\Account as AccountEntity;
use Exdrals\Bugebo\Repository\Account as AccountRepositoryInterface;
use Exdrals\Excidia\Component\Repository\Database;
use DateTime;

class Account implements AccountRepositoryInterface
{

    protected Database $database;
    
    public function __construct(Database $database) 
    {
        $this->database = $database;
    }
    
    public function createOrUpdate(AccountEntity $user)
    {
        
    }
    
    public function delete(AccountEntity $user)
    {
        
    }
    
    public function findByUUID(string $UUID) : ?AccountEntity
    {        
        return $this->findBy('uuid', $UUID);
    }
    
    public function findByName(string $name) : ?AccountEntity
    {        
        return $this->findBy('name', $name);        
    }

    public function findByEMail(string $email) : ?AccountEntity
    {
        return $this->findBy('email', $email);
    }

    protected function findBy(string $key, string $value): ?AccountEntity
    {        
        $sql = 'SELECT 
                        `uuid`, `name`, `email`, `passwordHash`, 
                        `registrationTime`, `lastActiv` 
                FROM 
                        `ex_accounts` 
                WHERE   
                        `'.$key.'`=:value'
                ;     
        
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
        $account->setRegistrationTime(new DateTime($result['registrationTime']));
        $account->setLastActive(new DateTime($result['lastActiv']));
        return $account;
    }    
}
