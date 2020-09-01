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
use Exdrals\Bugebo\Entities\{BankCodeEntity, BankNameEntity};
use Exdrals\Bugebo\Repositories\{PDORepository, BankCodeRepository, PDOBankNameRepository};

class PDOBankCodeRepository extends PDORepository implements BankCodeRepository
{
    private    $bankNameRepository = null;
    /**
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
        $this->setTableName('`bankCode`');
        $this->setAllColumnNames(
                                    '`id`, 
                                    `bankNameID`, 
                                    `bankCode`, 
                                    `bic`'
                                );
        $this->setEntityClassName('Exdrals\\Bugebo\\Entities\\BankCodeEntity');
        $this->bankNameRepository = new PDOBankNameRepository($pdo);        
    }
    
    /**
     * 
     * @param BankCodeEntity $bankCode
     * @return bool
     */
    public function createOrUpdate(BankCodeEntity $bankCode) : bool
    {                                                
        $bankNameSubQuery = '(SELECT `id` FROM '. $this->bankNameRepository->getTableName() . 'WHERE `bankName`=:bankName)';
        $query = $this->getCreateQuery(
                                            $this->getAllColumnNames(), 
                                            ':id, 
                                            '. $bankNameSubQuery .', 
                                            :bankCode, :bic'
                                        );
        $query .= $this->getOnDuplicateKeyUpdateQuery(
                                                        '`bankNameID`=VALUES(`bankNameID`), 
                                                        `bankCode`=VALUES(`bankCode`), 
                                                        `bic`=VALUES(`bic`)'
                                                    );
        $PDOStatement = $this->prepareQueryAndExecute(
                                                        $query, 
                                                        [
                                                            ':bankName' => $bankCode->getBankName(),
                                                            ':id' => $bankCode->getId(), 
                                                            ':bankCode' => $bankCode->getBankCode(), 
                                                            ':bic' => $bankCode->getBIC()
                                                        ]
                                                    );
        return $this->isPDOStatementError($PDOStatement);
    }    
        
    /**
     * 
     * @param int $id
     * @return BankCodeEntity|null
     */
    public function findByID(int $id) : ?BankCodeEntity
    {
        return $this->getEntityByColumn($this->getTableName().'.`id`', (string)$id);
    }
    
    /**
     * 
     * @param string $bankCode
     * @return array|null
     */
    public function findByBankCode(string $bankCode) : ?array
    {
        return $this->getEntityByColumnAsArray($this->getTableName().'.`bankCode`', $bankCode);
    }

    /**
     * 
     * @param string $bic
     * @return array|null
     */
    public function findByBIC(string $bic) : ?array
    {
        return $this->getEntityByColumnAsArray($this->getTableName().'.`bic`', $bic);
    }
    
    /**
     * 
     * @param string $bankName
     * @return array|null
     */
    public function findByBankName(string $bankName) : ?array
    {
        return $this->getEntityByColumnAsArray($this->bankNameRepository->getTableName().'.`bankName`', $bankName);
    }

    public function findByBankCodeAndBIC(string $bankCode, string $bic) :?BankCodeEntity
    {
        $query = $this->getSelectQuery() . 
                                            'WHERE '
                                        .        '`bankCode`=:bankCode '
                                        .   'AND ' 
                                        .       '`bic`=:bic';        
        $PDOStatement  = $this->prepareQueryAndExecute(
                                                            $query, 
                                                            [
                                                                ':bankCode' => $bankCode,
                                                                ':bic' => $bic
                                                            ]
                                                        );        
        $entity = $PDOStatement->fetchObject($this->getEntityClassName());
        if (!$entity) {
            return null;
        }        
        return $entity;
    }

    /**
     * 
     * @return array|null
     */
    public function findAll() : ?array
    {
        $query = $this->getSelectQuery();
        $PDOStatement  = $this->prepareQueryAndExecute($query);        
        $entity = $PDOStatement->fetchObject($this->getEntityClassName());
        if (!$entity) {
            return null;
        }
        if (\is_array($entity)) {
            return $entity;
        }
        return [$entity];
    }

    /**
     * @param   int $offset
     * @param   int $limit
     * @return array|null
     */
    public function findAllByRange(int $offset, int $limit) : ?array
    {
        $query = $this->getSelectQuery() . 'LIMIT ' . $offset.','.$limit;
        $PDOStatement  = $this->prepareQueryAndExecute($query);        
        $entity = $PDOStatement->fetchObject($this->getEntityClassName());
        if (!$entity) {
            return null;
        }
        if (\is_array($entity)) {
            return $entity;
        }
        return [$entity];
    }        
    
    /**
     * 
     * @param string $column
     * @param string $searchPattern
     * @return BankCodeEntity|null
     */
    protected function getEntityByColumn(string $column, string $searchPattern) : ?BankCodeEntity
    {
        $query = $this->getSelectQuery() . 'WHERE ' . $column.'=:condition';        
        $PDOStatement  = $this->prepareQueryAndExecute($query, [':condition' => $searchPattern]);        
        $entity = $PDOStatement->fetchObject($this->getEntityClassName());
        if (!$entity) {
            return null;
        }        
        return $entity;   
    }
    
    /**
     * 
     * @param string $column
     * @param string $searchPattern
     * @return array|null
     */
    private function getEntityByColumnAsArray(string $column, string $searchPattern) : ?array
    {
        $response = $this->getEntityByColumn($column, $searchPattern);
        if (!$response) {
            return null;
        }
        if (\is_array($response)) {
            return $response;
        }
        return [$response];
    }
    
    /**
     * 
     * @return string
     */
    private function getSelectQuery() : string
    {
        $bankCodeTable = $this->getTableName();
        $bankNameTable = $this->bankNameRepository->getTableName();
        return 'SELECT '
                .   $bankCodeTable.'.`id`, '
                .   $bankCodeTable.'.`bankCode`, '
                .   $bankCodeTable.'.`bic`, '
                .   $bankNameTable.'.`bankName` '
               . 'FROM '
                .   $bankCodeTable 
               . 'LEFT JOIN '
                .   $bankNameTable 
               . 'ON '
                .   $bankCodeTable.'.`bankNameID`='.$bankNameTable.'.`id` ';
    }
}
