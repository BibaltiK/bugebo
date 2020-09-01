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

use Exdrals\Bugebo\Entities\BankNameEntity;
use Exdrals\Bugebo\Repositories\{PDORepository, BankNameRepository};


class PDOBankNameRepository extends PDORepository implements BankNameRepository
{   
    /**
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo) 
    {
        parent::__construct($pdo);
        $this->setTableName('`bankName`');
        $this->setAllColumnNames(
                                    '`id`, 
                                    `bankName`'
                                );
        $this->setEntityClassName('Exdrals\\Bugebo\\Entities\\BankNameEntity');        
    }
    
    /**
     * 
     * @param BankNameEntity $bankName
     * @return bool
     */
    public function createOrUpdate(BankNameEntity $bankName) : bool
    {
        $query  = $this->getCreateQuery(
                                            $this->getAllColumnNames(), 
                                            ':id, 
                                            :bankName'
                                        );        
        $query .= $this->getOnDuplicateKeyUpdateQuery('`bankName`=VALUES(`bankName`)');
        $PDOStatement = $this->prepareQueryAndExecute(
                                                        $query, 
                                                        [
                                                            ':id' => $bankName->getId(),
                                                            ':bankName' => $bankName->getBankName()
                                                        ]
                                                    );
        return $this->isPDOStatementError($PDOStatement);
    }        
    /**
     * 
     * @param int $id
     * @return BankNameEntity|null
     */
    public function findByID(int $id) : ?BankNameEntity
    {
        return $this->getEntityByColumn('`id`', (string)$id);
    }
    
    /**
     * 
     * @param string $bankName
     * @return BankNameEntity|null
     */
    public function findByBankName(string $bankName) : ?BankNameEntity
    {
        return $this->getEntityByColumn('`bankName`', $bankName);
    }            
}
