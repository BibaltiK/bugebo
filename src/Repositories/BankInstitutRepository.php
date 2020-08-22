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

use Exdrals\Bugebo\Entities\BankInstitutEntity;

interface BankInstitutRepository extends Repository
{
    /**
     * 
     * @param BankInstitutEntity $bankInstitut
     * @return bool
     */
    public function createOrUpdate(BankInstitutEntity $bankInstitut) : bool;
    
    /**
     * 
     * @param int $id
     * @return BankInstitutEntity|null
     */
    public function findByID(int $id) : ?BankInstitutEntity;
    
    /**
     * 
     * @param string $bankName
     * @return array|null
     */
    public function findByBankName(string $bankName) : ?array;
    
    /**
     * 
     * @param string $bankCode
     * @return array|null
     */
    public function findByBankCode(string $bankCode) : ?array;
    
    /**
     * 
     * @param string $bic
     * @return array|null
     */
    public function findByBic(string $bic) : ?array;
    
    /**
     * 
     * @param string $cityName
     * @return array|null
     */
    public function findByCityName(string $cityName) : ?array;
    
    /**
     * 
     * @param string $zipCode
     * @return array|null
     */
    public function findByZipCode(string $zipCode) : ?array;
    
    /**
     * 
     * @param string $street
     * @return array|null
     */
    public function findByStreet(string $street) : ?array;
    
    /**
     * 
     * @param string $houseNumber
     * @return array|null
     */
    public function findByHouseNumber(string $houseNumber) : ?array;
    
    /**
     * 
     * @param string $phone
     * @return array|null
     */
    public function findByPhone(string $phone) : ?array;
    
    /**
     * 
     * @param string $fax
     * @return array|null
     */
    public function findByFax(string $fax) : ?array;
    
    /**
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email) : ?array;
    
    /**
     * 
     * @param string $website
     * @return array|null
     */
    public function findByWebsite(string $website) : ?array;
}
