<?php
/**
 *
 * MIT License
 *
 * Copyright (c) 2014-2020 BibaltiK - eXdraLs.de
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @package     Exdrals\Bugebo
 * @version     0.1-dev
 * @author      BibaltiK
 * @see         https://github.com/BibaltiK/bugebo
 * @copyright   2020 exdrals.de
 * @link        http://bugebo.exdrals.de
 * @license     MIT License <https://opensource.org/licenses/MIT>
 */
declare(strict_types=1);

namespace Exdrals\Bugebo\Repositories;

use Exdrals\Bugebo\Entities\AccountEntity;
use Exdrals\Bugebo\Repositories\{PDORepository, AccountRepository};
use Ramsey\Uuid\Uuid;


class PDOAccountRepository extends PDORepository implements AccountRepository
{
    /**
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo) 
    {
        parent::__construct($pdo);
        $this->setTableName('`accounts`');
        $this->setAllColumnNames(
                                    '`uuid`, 
                                    `name`, 
                                    `email`, 
                                    `passwordHash`, 
                                    `registrationTime`, 
                                    `lastActiv`'
                                );
        $this->setEntityClassName('Exdrals\\Bugebo\\Entities\\AccountEntity');
    }        
    
    /**
     * 
     * @param AccountEntity $account
     * @return bool
     */
    public function createOrUpdate(AccountEntity $account) : bool
    {                
        $bindParam = [
                        ':uuid'             =>  $account->getUuid(),
                        ':name'             =>  $account->getName(),
                        ':email'            =>  $account->getEmail(),
                        ':passwordHash'     =>  $account->getPasswordHash()
                    ];
        $query = $query = $this->getCreateQuery(
                                                    $this->getAllColumnNames(), 
                                                    ':uuid, 
                                                    :name, 
                                                    :email, 
                                                    :passwordHash, 
                                                    NOW(), 
                                                    NOW()'
                                                );
        $query .= $this->getOnDuplicateKeyUpdateQuery(
                                                        '`name`=VALUES(`name`), 
                                                        `email`=VALUES(`email`), 
                                                        `passwordHash`=VALUES(`passwordHash`)'
                                                    );
        $PDOStatement = $this->prepareQueryAndExecute($query, $bindParam);
        return $this->isPDOStatementError($PDOStatement);
    }
        
    /**
     * 
     * @param string $uuid
     * @return bool
     */
    public function updateLastActiv(string $id) : bool
    {
        $query          = $this->getUpdateQuery(
                                                    '`lastActiv`=NOW() ', 
                                                    '`uuid`=:uuid'
                                                );
        $PDOStatement   = $this->prepareQueryAndExecute($query, [':uuid' => $id]);
        return $this->isPDOStatementError($PDOStatement);
    }

    /**
     * 
     * @param string $uuid
     * @return bool
     */
    public function deleteUUID(string $uuid) : bool
    {
        $query          = $this->getDeleteQuery('`uuid`=:uuid');
        $PDOStatement   = $this->prepareQueryAndExecute($query, [':uuid' => $uuid]);
        return $this->isPDOStatementError($PDOStatement);
    }
    
    public function delete(int $id) : bool
    {
        $uuid = Uuid::fromInteger($id);
        return $this->deleteUUID($uuid->toString());
    }
    
    /**
     * 
     * @param string $uuid
     * @return AccountEntity|null
     */
    public function findByUUID(string $uuid) : ?AccountEntity    
    {        
        return $this->getEntityByColumn('`uuid`', $uuid);
    }
    
    /**
     * 
     * @param string $name
     * @return AccountEntity|null
     */
    public function findByName(string $name) : ?AccountEntity
    {
        return $this->getEntityByColumn('`name`', $name);
    }
    
    /**
     * 
     * @param string $email
     * @return AccountEntity|null
     */
    public function findByEmail(string $email) : ?AccountEntity
    {
        return $this->getEntityByColumn('`email`', $email);
    }                                
}
