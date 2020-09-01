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

namespace Exdrals\Bugebo\Develop;

require_once __DIR__ . '/../Configs/ProjectDefines.php';

use Exdrals\Bugebo\Repositories\{AccountRepository, StreetRepository, CityRepository, BankNameRepository, BankCodeRepository, BankAccountTypRepository, BankInstitutRepository};
use Exdrals\Bugebo\Entities\{AccountEntity, StreetEntity, CityEntity, BankNameEntity, BankCodeEntity, BankAccountTypEntity, BankInstitutEntity};
use Ramsey\Uuid\Uuid;

class developTools {
    
    public static function createDemoAccount(AccountRepository $accountRepository)
    {
        $demoAccount = new AccountEntity();
        $demoAccount->setUuid(DEMOACCOUNT_UUID);
        $demoAccount->setName(DEMOACCOUNT_NAME);
        //$demoAccount->setName('DEMOACCOUNT_NAME');
        $demoAccount->setEmail(DEMOACCOUNT_EMAIL);
        $demoAccount->setPasswordHash(DEMOACCOUNT_PASSWORDHASH);
        $accountRepository->createOrUpdate($demoAccount);
    }
    
    public static function createDemoStreet(StreetRepository $streetRepository)
    {
        $demoStreet = new StreetEntity();
        $demoStreet->setStreet('Demostrasse');
        $streetRepository->createOrUpdate($demoStreet);
    }
    
    public static function createDemoCity(CityRepository $cityRepository)
    {
        $demoCity = new CityEntity();
        $demoCity->setCityName('Demo-Stadt');
        $demoCity->setZipCode('12345');
        $cityRepository->createOrUpdate($demoCity);
    }
    
    public static function createDemoBankName(BankNameRepository $bankNameRepository)
    {
        $demoBankName = new BankNameEntity();
        $demoBankName->setBankName('Demo-Bankname');
        $bankNameRepository->createOrUpdate($demoBankName);
    }
    
    public static function createDemoBankCode(BankCodeRepository $bankCodeRepository)
    {
        $demoBankCode = new BankCodeEntity();
        $demoBankCode->setBankName('Demo-Bankname');
        $demoBankCode->setBankCode('95070724');
        $demoBankCode->setBIC('ABCDEF');
        $bankCodeRepository->createOrUpdate($demoBankCode);
    }
    
    public static function createDemoBankAccountTyp(BankAccountTypRepository $bankAccountTypRepository)
    {
        $demoBankAccountTyp = new BankAccountTypEntity();
        $demoBankAccountTyp->setBankAccountTypName('Demo-BankAccountTyp');
        $demoBankAccountTyp->setDescription('nur zur Demonstration');        
        $bankAccountTypRepository->createOrUpdate($demoBankAccountTyp);
    }
    
    public static function createDemoBankInstitut(BankInstitutRepository $bankInstitutRepository)
    {
        $demoBankInstitut = new BankInstitutEntity();
        $demoBankInstitut->setId(1);
        $demoBankInstitut->setBankName('Demo-Bankname');
        $demoBankInstitut->setBankCode('95070724');
        $demoBankInstitut->setBic('ABCDEF');
        $demoBankInstitut->setCityName('Demo-Stadt');
        $demoBankInstitut->setZipCode('12345');
        $demoBankInstitut->setStreet('Demostrasse');
        $demoBankInstitut->setHouseNumber('29A');
        $demoBankInstitut->setPhone('1234512541351');
        $demoBankInstitut->setFax('0320429083741');
        $demoBankInstitut->setEmail('demo@exdrals.de');
        $demoBankInstitut->setWebsite('demo.exdrals.de');
        $bankInstitutRepository->createOrUpdate($demoBankInstitut);
    }
}
