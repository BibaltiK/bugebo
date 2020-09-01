<?php

namespace Exdrals\Bugebo\Interfaces;

use Exdrals\Bugebo\Entity\Account;

interface AccountRepository
{    
    /**
     * 
     * @param AccountEntity $account
     * @return bool
     */
    public function createOrUpdate(AccountEntity $account) : bool;
        
    /**
     * 
     * @param string $uuid
     * @return bool
     */
    public function updateLastActiv(string $uuid) : bool;
    
    /**
     * 
     * @param string $uuid
     * @return bool
     */
    public function deleteUUID(string $uuid) : bool;
    
    /**
     * 
     * @param string $uuid
     * @return AccountEntity|null
     */
    public function findByUUID(string $uuid) : ?AccountEntity;
    
    /**
     * 
     * @param string $name
     * @return AccountEntity|null
     */
    public function findByName(string $name) : ?AccountEntity;
    
    /**
     * 
     * @param string $email
     * @return AccountEntity|null
     */
    public function findByEmail(string $email) : ?AccountEntity;
    
    /**
     * 
     * @return array|null
     */
    public function findAll() : ?array;

    /**
     * @param   int $offset
     * @param   int $limit
     * @return array|null
     */
    public function findAllByRange(int $offset, int $limit) : ?array;
}
