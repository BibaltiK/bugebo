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

use Exdrals\Bugebo\Repositories\{PDOBankCodeRepository, PDOBankNameRepository, PDOCityRepository, PDOStreetRepository};
use Exdrals\Bugebo\Entities\BankInstitutEntity;


class PDOBankInstitutRepository extends PDORepository implements BankInstitutRepository
{
    private $bankCodeRepository = null;
    private $bankNameRepository = null;
    private $cityRepository     = null;
    private $streetRepository   = null;
    
    /**
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
        $this->setTableName('`bankInstitut`');
        $this->setAllColumnNames(
                                    '`id`, 
                                    `bankCodeID`, 
                                    `cityID`, 
                                    `streetID`, 
                                    `houseNumber`, 
                                    `phone`, 
                                    `fax`, 
                                    `email`, 
                                    `website`'
                                );
        $this->setEntityClassName('Exdrals\\Bugebo\\Entities\\BankInstitutEntity');
        $this->bankCodeRepository = new PDOBankCodeRepository($pdo);
        $this->bankNameRepository = new PDOBankNameRepository($pdo);
        $this->cityRepository = new PDOCityRepository($pdo);
        $this->streetRepository = new PDOStreetRepository($pdo);        
    }
    
    /**
     * 
     * @param BankInstitutEntity $bankInstitut
     * @return bool
     */
    public function createOrUpdate(BankInstitutEntity $bankInstitut) : bool
    {
        $bankCodeSubQuery = '(SELECT '
                        .       $this->bankCodeRepository->getTableName().'.`id` '
                        .    'FROM ' 
                        .       $this->bankCodeRepository->getTableName() 
                        .   'WHERE '
                        .       '`bankCode`=:bankCode '
                        .   'AND '
                        .       '`bic`=:bic)';
        $citySubQuery   = '(SELECT '
                        .       $this->cityRepository->getTableName().'.`id` '
                        .   'FROM '
                        .       $this->cityRepository->getTableName()
                        .   'WHERE '
                        .       '`cityName`=:cityName '
                        .   'AND '
                        .       '`zipCode`=:zipCode)';
        $streetSubQuery = '(SELECT '
                        .       $this->streetRepository->getTableName().'.`id` '
                        .   'FROM '
                        .       $this->streetRepository->getTableName()
                        .   'WHERE '
                        .       '`street`=:street)';
        $query = $this->getCreateQuery(
                                            $this->getAllColumnNames(), 
                                            ':id, '
                                        .   $bankCodeSubQuery .', '
                                        .   $citySubQuery . ', '
                                        .   $streetSubQuery . ', '
                                        .   ':houseNumber, '
                                        .   ':phone, '
                                        .   ':fax, '
                                        .   ':email, '
                                        .   ':website'
                                        );
        $query .= $this->getOnDuplicateKeyUpdateQuery(
                                                         '`bankCodeID`=VALUES(`bankCodeID`), '
                                                        .'`cityID`=VALUES(`cityID`),  '
                                                        .'`streetID`=VALUES(`streetID`), '
                                                        .'`houseNumber`=VALUES(`houseNumber`), '
                                                        .'`phone`=VALUES(`phone`), '
                                                        .'`fax`=VALUES(`fax`), '
                                                        .'`email`=VALUES(`email`), '
                                                        .'`website`=VALUES(`website`)'
                                                    );
        $PDOStatement = $this->prepareQueryAndExecute(
                                                        $query, 
                                                        [
                                                            ':id' => $bankInstitut->getId(),
                                                            ':bankCode' => $bankInstitut->getBankCode(),
                                                            ':bic' => $bankInstitut->getBic(),
                                                            ':cityName' => $bankInstitut->getCityName(),
                                                            ':zipCode' => $bankInstitut->getZipCode(),
                                                            ':street' => $bankInstitut->getStreet(),
                                                            ':houseNumber' => $bankInstitut->getHouseNumber(),
                                                            ':phone' => $bankInstitut->getPhone(),
                                                            ':fax' => $bankInstitut->getFax(),
                                                            ':email' => $bankInstitut->getEmail(),
                                                            ':website' => $bankInstitut->getWebsite()                                                            
                                                        ]
                                                    );
        return $this->isPDOStatementError($PDOStatement);
    }
    
    /**
     * 
     * @param int $id
     * @return BankInstitutEntity|null
     */
    public function findByID(int $id) : ?BankInstitutEntity
    {
        return $this->getEntityByColumn($this->getTableName().'.`id`', (string)$id);
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
    
    /**
     * 
     * @param string $bankCode
     * @return array|null
     */
    public function findByBankCode(string $bankCode) : ?array
    {
        return $this->getEntityByColumnAsArray($this->bankCodeRepository->getTableName().'.`bankCode`', $bankCode);
    }
    
    /**
     * 
     * @param string $bic
     * @return array|null
     */
    public function findByBic(string $bic) : ?array
    {
        return $this->getEntityByColumnAsArray($this->bankCodeRepository->getTableName().'.`bic`', $bic);
    }
    
    /**
     * 
     * @param string $cityName
     * @return array|null
     */
    public function findByCityName(string $cityName) : ?array
    {
        return $this->getEntityByColumnAsArray($this->cityRepository->getTableName().'.`cityName`', $cityName);
    }
    
    /**
     * 
     * @param string $zipCode
     * @return array|null
     */
    public function findByZipCode(string $zipCode) : ?array
    {
        return $this->getEntityByColumnAsArray($this->cityRepository->getTableName().'.`zipCode`', $zipCode);
    }
    
    /**
     * 
     * @param string $street
     * @return array|null
     */
    public function findByStreet(string $street) : ?array
    {
        return $this->getEntityByColumnAsArray($this->streetRepository->getTableName().'.`street`', $street);
    }
    
    /**
     * 
     * @param string $houseNumber
     * @return array|null
     */
    public function findByHouseNumber(string $houseNumber) : ?array
    {
        return $this->getEntityByColumnAsArray($this->getTableName().'.`houseNumber`', $houseNumber);
    }
    
    /**
     * 
     * @param string $phone
     * @return array|null
     */
    public function findByPhone(string $phone) : ?array
    {
        return $this->getEntityByColumnAsArray($this->getTableName().'.`phone`', $phone);
    }
    
    /**
     * 
     * @param string $fax
     * @return array|null
     */
    public function findByFax(string $fax) : ?array
    {
        return $this->getEntityByColumnAsArray($this->getTableName().'.`fax`', $fax);
    }
    
    /**
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email) : ?array
    {
        return $this->getEntityByColumnAsArray($this->getTableName().'.`email`', $email);
    }
    
    /**
     * 
     * @param string $website
     * @return array|null
     */
    public function findByWebsite(string $website) : ?array
    {
        return $this->getEntityByColumnAsArray($this->getTableName().'.`website`', $website);
    }
    
    /**
     * 
     * @param string $column
     * @param string $searchPattern
     * @return BankCodeEntity|null
     */
    protected function getEntityByColumn(string $column, string $searchPattern) : ?BankInstitutEntity
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
        $bankInstitutTable = $this->getTableName();
        $bankCodeTable = $this->bankCodeRepository->getTableName();
        $bankNameTable = $this->bankNameRepository->getTableName();
        $cityTable = $this->cityRepository->getTableName();
        $streetTable = $this->streetRepository->getTableName();
        return 'SELECT '
                .   $bankInstitutTable.'.`id`, '
                .   $bankNameTable.'.`bankName`, '
                .   $bankCodeTable.'.`bankCode`, '
                .   $bankCodeTable.'.`bic`, '
                .   $cityTable.'.`cityName`, '
                .   $cityTable.'.`zipCode`, '
                .   $streetTable.'.`street`, '
                .   $bankInstitutTable.'.`houseNumber`, '
                .   $bankInstitutTable.'.`phone`, '
                .   $bankInstitutTable.'.`fax`, '
                .   $bankInstitutTable.'.`email`, '
                .   $bankInstitutTable.'.`website` '
               . 'FROM '
                .   $bankInstitutTable 
               . 'LEFT JOIN '
                .   $bankCodeTable
               . 'ON '
                .   $bankInstitutTable.'.`bankCodeID`='.$bankCodeTable.'.`id` '
                .'LEFT JOIN '
                .   $bankNameTable
                .'ON '
                .   $bankCodeTable.'.`bankNameID`='.$bankNameTable.'.`id` '
                .'LEFT JOIN '
                .   $cityTable
                .'ON '
                .   $bankInstitutTable.'.`cityID`='.$cityTable.'.`id`'
                .'LEFT JOIN '
                .   $streetTable
                .'ON '
                .   $bankInstitutTable.'.`streetID`='.$streetTable.'.`id` ';
    }
}
