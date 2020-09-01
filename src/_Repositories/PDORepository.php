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
 * @version     0.2-dev
 * @author      BibaltiK
 * @see         https://github.com/BibaltiK/bugebo
 * @copyright   2020 exdrals.de
 * @link        http://bugebo.exdrals.de
 * @license     MIT License <https://opensource.org/licenses/MIT>
 */
declare(strict_types=1);

namespace Exdrals\Bugebo\Repositories;

abstract class PDORepository 
{
    protected $pdo              =   null;
    protected $tableName        =   '';
    protected $entityClassName  =   '';
    protected $columnNames      =   '';
    protected $dbPrefix         =   '';

    /**
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo) 
    {
        $this->pdo = $pdo;
        $this->setDbPrefix('ex_');
    }
    
    /**
     * 
     * @param string $dbPrefix
     */
    protected function setDbPrefix(string $dbPrefix) 
    {
        $this->dbPrefix = $dbPrefix;        
    }

    /**
     * 
     * @param string $tableName
     */
    protected function setTableName(string $tableName)
    {
        $this->tableName = str_replace('`', '',$tableName);
        $this->dbPrefix;
    }    

    /**
     * 
     * @param string $entityClassName
     */
    protected function setEntityClassName(string $entityClassName)
    {
        $this->entityClassName = $entityClassName;
    }

    /**
     * 
     * @param string $columnName
     */
    protected function setAllColumnNames(string $columnNames)
    {
        $this->columnNames = $columnNames;
    }

    /**
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool
    {
        $query          = $this->getDeleteQuery('`id`=:id');
        $PDOStatement   = $this->prepareQueryAndExecute($query, [':id' => $id]);
        return $this->isPDOStatementError($PDOStatement);
    }
    
    /**
     * 
     * @return array|null
     */
    public function findAll() : ?array
    {
        $query          = $this->getFindAllQuery($this->getAllColumnNames());
        $PDOStatement   = $this->prepareQueryAndExecute($query);
        $entities       = $PDOStatement->fetchAll(\PDO::FETCH_CLASS, $this->getEntityClassName());
        if (!$entities)
        {
            return null;
        }
        return $entities;
    }

    /**
     * @param   int $offset
     * @param   int $limit
     * @return array|null
     */
    public function findAllByRange(int $offset, int $limit) : ?array
    {
        $query          = $this->getFindAllQuery($this->getAllColumnNames()) . 'LIMIT '.$offset.', '.$limit;
        $PDOStatement   = $this->prepareQueryAndExecute($query);
        $entities       = $PDOStatement->fetchAll(\PDO::FETCH_CLASS, $this->getEntityClassName());
        if (!$entities)
        {
            return null;
        }
        return $entities;
    }
    
    /**
     * 
     * @param string $column
     * @param string $searchPattern
     * @return Entity|null
     */
    protected function getEntityByColumn(string $column, string $searchPattern)
    {
        $query          = $this->getFindByQuery($this->getAllColumnNames(), $column.'=:condition');
        $PDOStatement   = $this->prepareQueryAndExecute($query, [':condition' => $searchPattern]);
        $entity         = $PDOStatement->fetchObject($this->getEntityClassName());
        if (!$entity)
        {
            return null;
        }
        return $entity;
    }
    
    /**
     * 
     * @param   string $column      All relevant columns    Example: '`id`, `column`'
     * @param   string $bindParams  All bound parameters    Example: '`column`=:column'
     * @return  string              Compound query string
     */
    protected function getCreateQuery(string $column, string $bindParams) : string
    {        
        $query = 'INSERT INTO '
                .   $this->getTableName()
                .       ' ('
                .           $column
                .       ') '
                . 'VALUES '
                .       '('
                .           $bindParams
                .       ')';
        return $query;
    }
    
    protected function getOnDuplicateKeyUpdateQuery(string $column)
    {
        $query = ' ON DUPLICATE KEY UPDATE '.$column;
        return $query;
    }


    /**
     * 
     * @param   string $column      All relevant columns    Example: '`id`, `column`'
     * @param   string $condition   The WHERE condition     Example: '`id`=:id
     * @return  string              Compound query string
     */
    protected function getUpdateQuery(string $column, string $condition) : string
    {
        $query =  'UPDATE '
                .       $this->getTableName()
                . ' SET '
                .       $column
                . ' WHERE '
                .       $condition;
        return $query;
    }
    
    /**
     * 
     * @param   string $condition   The WHERE condition     Example: '`id`=:id
     * @return  string              Compound query string
     */
    protected function getDeleteQuery(string $condition) : string
    {
        $query =  'DELETE FROM '
                .       $this->getTableName()
                . 'WHERE '
                .       $condition;
        return $query;
    }
    
    /**
     * 
     * @param   string $column      All relevant columns    Example: '`id`, `column`'
     * @param   string $condition   The WHERE condition     Example: '`id`=:id
     * @return  string              Compound query string
     */
    protected function getFindByQuery(string $column, string $condition) : string
    {
        $query = 'SELECT '
                        . $column 
                  . 'FROM '
                        . $this->getTableName()
                  . 'WHERE '
                .           $condition;
        return $query;
    }
    
    /**
     * 
     * @param   string $column      All relevant columns    Example: '`id`, `column`'
     * @return  string              Compound query string
     */
    protected function getFindAllQuery(string $column) : string
    {
        $query = 'SELECT '
                        . $column 
                  . 'FROM '
                        . $this->getTableName();
        return $query;
    }
    
    /**
     * 
     * @param   string  $query
     * @param   array   $bindParam|null
     * @return  \PDOStatement
     */
    protected function prepareQueryAndExecute(string $query, ?array $bindParam=null) : \PDOStatement
    {
        //var_dump($query);
        $PDOStatement = $this->pdo->prepare($query);        
        //var_dump($this->pdo->errorInfo());
        $PDOStatement->execute($bindParam);       
        //var_dump($PDOStatement->errorInfo());
        return $PDOStatement;
    }
    
    /**
     * 
     * @param \PDOStatement $PDOStatement
     * @return bool
     */
    protected function isPDOStatementError(\PDOStatement $PDOStatement) : bool
    {
        if ($PDOStatement->errorCode() !== '00000')
        {
            return false;
        }
        return true;
    }
    
    /**
     * 
     * @return string
     */
    protected function getTableName() : string
    {
        return '`' . $this->getDbPrefix() . $this->tableName . '`';
    }
    
    /**
     * 
     * @return string
     */
    protected function getDbPrefix() : string
    {
        return $this->dbPrefix;
    }
    
    /**
     * 
     * @return string
     */
    protected function getEntityClassName() : string
    {
        return $this->entityClassName;
    }
    
    /**
     * 
     * @return string
     */
    protected function getAllColumnNames() : string
    {
        return $this->columnNames;
    }
}
