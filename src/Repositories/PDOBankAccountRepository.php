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
use Exdrals\Bugebo\Entities\BankAccountEntity;


class PDOBankAccountRepository extends PDORepository implements BankAccountRepository
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
        $this->setTableName('`bankAccount`');
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
        $this->setEntityClassName('Exdrals\\Bugebo\\Entities\\BankAccountEntity');
        $this->bankCodeRepository = new PDOBankCodeRepository($pdo);
        $this->bankNameRepository = new PDOBankNameRepository($pdo);
        $this->cityRepository = new PDOCityRepository($pdo);
        $this->streetRepository = new PDOStreetRepository($pdo);        
    }
}
