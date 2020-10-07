<?php


namespace Exdrals\Bugebo\Repository;

use Exdrals\Bugebo\Entity\Account as AccountEntity;

interface Account
{
    public function createOrUpdate(AccountEntity $user);
    public function delete(AccountEntity $user);
    public function findByUUID(string $UUID) : ?AccountEntity;
    public function findByName(string $name) : ?AccountEntity;
    public function findByEMail(string $email) : ?AccountEntity;
}