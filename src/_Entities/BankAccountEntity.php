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

namespace Exdrals\Bugebo\Entities;

class BankAccount
{
    private $id             =   0;

    private $bankAccountTyp =   '';

    private $bankName       =   '';
    
    private $bankCode       =   '';
    
    private $bic            =   '';
    
    private $cityName       =   '';
    
    private $zipCode        =   '';
    
    private $street         =   '';
    
    private $houseNumber    =   '';
    
    private $phone          =   '';
    
    private $fax            =   '';
    
    private $email          =   '';
    
    private $website        =   '';

    private $accountName    =   '';

    private $description    =   '';

    private $openingDate    =   null;

    private $lastModified   =   null;

    public function getId() : int
    {
        return $this->id;
    }

    public function getBankAccountTyp() : string 
    {
        return $this->bankAccountTyp;
    }

    public function getBankName() : string 
    {
        return $this->bankName;
    }

    public function getBankCode() : string
    {
        return $this->bankCode;
    }

    public function getBic() : string 
    {
        return $this->bic;
    }

    public function getCityName() : string 
    {
        return $this->cityName;
    }

    public function getZipCode() : string 
    {
        return $this->zipCode;
    }

    public function getStreet() : string 
    {
        return $this->street;
    }

    public function getHouseNumber() : string 
    {
        return $this->houseNumber;
    }

    public function getPhone() : string 
    {
        return $this->phone;
    }

    public function getFax() : string 
    {
        return $this->fax;
    }

    public function getEmail() : string 
    {
        return $this->email;
    }

    public function getWebsite() : string 
    {
        return $this->website;
    }

    public function getAccountName() : string 
    {
        return $this->accountName;
    }

    public function getDescription() : string 
    {
        return $this->description;
    }

    public function getOpeningDate() : string
    {
        return $this->openingDate;
    }

    public function getLastModified() : string
    {
        return $this->lastModified;
    }

    public function setId(int $id) : void 
    {
        $this->id = $id;
    }

    public function setBankAccountTyp(string $bankAccountTyp) : void 
    {
        $this->bankAccountTyp = $bankAccountTyp;
    }

    public function setBankName(string $bankName) : void 
    {
        $this->bankName = $bankName;
    }

    public function setBankCode(string $bankCode) : void 
    {
        $this->bankCode = $bankCode;
    }

    public function setBic(string $bic) : void 
    {
        $this->bic = $bic;
    }

    public function setCityName(string $cityName) : void 
    {
        $this->cityName = $cityName;
    }

    public function setZipCode(string $zipCode) : void 
    {
        $this->zipCode = $zipCode;
    }

    public function setStreet(string $street) : void 
    {
        $this->street = $street;
    }

    public function setHouseNumber(string $houseNumber) : void 
    {
        $this->houseNumber = $houseNumber;
    }

    public function setPhone(string $phone) : void 
    {
        $this->phone = $phone;
    }

    public function setFax(string $fax) : void 
    {
        $this->fax = $fax;
    }

    public function setEmail(string $email) : void 
    {
        $this->email = $email;
    }

    public function setWebsite(string $website) : void 
    {
        $this->website = $website;
    }

    public function setAccountName(string $accountName) : void 
    {
        $this->accountName = $accountName;
    }

    public function setDescription(string $description) : void 
    {
        $this->description = $description;
    }

    public function setOpeningDate(string $openingDate) : void 
    {
        $this->openingDate = $openingDate;
    }

    public function setLastModified(string $lastModified) : void 
    {
        $this->lastModified = $lastModified;
    }
}