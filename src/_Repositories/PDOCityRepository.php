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

use Exdrals\Bugebo\Entities\CityEntity;
use Exdrals\Bugebo\Repositories\{PDORepository, CityRepository};


class PDOCityRepository extends PDORepository implements CityRepository
{   
    /**
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo) 
    {
        parent::__construct($pdo);
        $this->setTableName('`city`');
        $this->setAllColumnNames(
                                    '`id`, 
                                    `cityName`, 
                                    `zipCode`'
                                );
        $this->setEntityClassName('Exdrals\\Bugebo\\Entities\\CityEntity');        
    }
    
    /**
     * 
     * @param CityEntity $city
     * @return bool
     */
    public function createOrUpdate(CityEntity $city) : bool
    {
        $query  = $this->getCreateQuery(
                                            $this->getAllColumnNames(), 
                                            ':id, 
                                            :name, 
                                            :zipCode'
                                        );        
        $query .= $this->getOnDuplicateKeyUpdateQuery(
                                                        '`cityName`=VALUES(`cityName`), 
                                                        `zipCode`=VALUES(`zipCode`)'
                                                    );
        $PDOStatement = $this->prepareQueryAndExecute(
                                                        $query, 
                                                        [
                                                            ':id' => $city->getId(),
                                                            ':name' => $city->getCityName(), 
                                                            ':zipCode' =>$city->getZipCode()
                                                        ]
                                                    );
        return $this->isPDOStatementError($PDOStatement);
    }    
        
    /**
     * 
     * @param int $id
     * @return CityEntity|null
     */
    public function findByID(int $id) : ?CityEntity
    {
        return $this->getEntityByColumn('`id`', (string)$id);
    }
    
    /**
     * 
     * @param string $cityName
     * @return array|null
     */
    public function findByCityName(string $cityName) : ?array
    {
        return $this->getEntityByColumnAsArray('`cityName`', $cityName);        
    }
    
    /**
     * 
     * @param string $zipCode
     * @return array|null
     */
    public function findByZipCode(string $zipCode) : ?array
    {
        return $this->getEntityByColumnAsArray('`zipCode`', $zipCode);        
    }

    public function findByCityNameAndZipCode(string $cityName, string $zipCode) : ?CityEntity
    {
        $query = $this->getSelectQuery() . 
                                            'WHERE '
                                        .        '`cityName`=:cityName '
                                        .   'AND ' 
                                        .       '`zipCode`=:zipCode';        
        $PDOStatement  = $this->prepareQueryAndExecute(
                                                            $query, 
                                                            [
                                                                ':cityName' => $cityName,
                                                                ':zipCode' => $zipCode
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
     * @param string $column
     * @param string $searchPattern
     * @return arry|null
     */
    private function getEntityByColumnAsArray(string $column, string $searchPattern) : ?array
    {
        $cityEntites = $this->getEntityByColumn($column, $searchPattern);
        if (!$cityEntites)
            return null;
        if (\is_array($cityEntites))
            return $cityEntites;
        return [$cityEntites];
    }
}
