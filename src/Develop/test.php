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
use Exdrals\Bugebo\Entities\{AccountEntity, StreetEntity, CityEntity, BankNameEntity, BankCodeEntity, BankAccountTypEntity, BankInstitutEntity};
use Exdrals\Bugebo\Repositories\{PDOAccountRepository, PDOStreetRepository, PDOCityRepository, PDOBankNameRepository, PDOBankCodeRepository, PDOBankAccountTypRepository, PDOBankInstitutRepository};
use Exdrals\Bugebo\Develop\developTools;

require_once __DIR__ . '/../Configs/ProjectDefines.php';

$pdoConfig = require_once __DIR__ . '/../Configs/pdoConfig.php';

$pdo = new \PDO($pdoConfig['dsn'], $pdoConfig['username'], $pdoConfig['password'], $pdoConfig['options']);
echo '<pre>';
/**
 * ACCOUNT
 */
$accountRepository = new PDOAccountRepository($pdo);
developTools::createDemoAccount($accountRepository);



$accountEntity = $accountRepository->findByUUID(DEMOACCOUNT_UUID);
echo '<b>AccountEntity by UUID:</b>';
var_dump($accountEntity);

$accountEntity = $accountRepository->findByName(DEMOACCOUNT_NAME);
echo '<b>AccountEntity by Name:</b>';
var_dump($accountEntity);

$accountEntity = $accountRepository->findByEmail(DEMOACCOUNT_EMAIL);
echo '<b>AccountEntity by E-Mail:</b>';
var_dump($accountEntity);

$accountRepository->updateLastActiv(DEMOACCOUNT_UUID);
$accountEntity = $accountRepository->findByUUID(DEMOACCOUNT_UUID);
echo '<b>AccountEntity by UUID nach Update:</b>';
var_dump($accountEntity);

$accountEntities = $accountRepository->findAll();
echo '<b>All AccountEntities: </b>';
var_dump($accountEntities);


/**
 * STREET
 */
$streetRepository = new PDOStreetRepository($pdo);
developTools::createDemoStreet($streetRepository);
$streetEntity = $streetRepository->findByID(1);
echo '<b>StreetEntity by ID:</b>';
var_dump($streetEntity);

$streetEntity = $streetRepository->findByStreet('Demostrasse');
echo '<b>StreetEntity by Street:</b>';
var_dump($streetEntity);

$streetRepository->createOrUpdate($streetEntity);
$streetEntity = $streetRepository->findByID($streetEntity->getId());
echo '<b>StreetEntity by ID nach Update:</b>';
var_dump($streetEntity);

$streetEntities = $streetRepository->findAll();
echo '<b>All StreetEntity:</b>';
var_dump($streetEntities);

/**
 * CITY
 */
$cityRepository = new PDOCityRepository($pdo);
developTools::createDemoCity($cityRepository);
$cityEntity = $cityRepository->findByID(1);
echo '<b>CityEntity by ID:</b>';
var_dump($cityEntity);

$cityEntity = $cityRepository->findByCityName('Demo-Stadt');
echo '<b>CityEntity find by City:</b>';
var_dump($cityEntity);

$cityEntity = $cityRepository->findByZipCode('12345');
echo '<b>CityEntity find by zipCode:</b>';
var_dump($cityEntity);  

$cityRepository->createOrUpdate($cityEntity[0]);
$cityEntity = $cityRepository->findByID($cityEntity[0]->getId());
echo '<b>CityEntity by ID nach Update:</b>';
var_dump($cityEntity);

$cityEntities = $cityRepository->findAll();
echo '<b>All CityEntity:</b>';
var_dump($cityEntities);


/**
 * BANKNAME
 */
$bankNameRepository = new PDOBankNameRepository($pdo);
developTools::createDemoBankName($bankNameRepository);
$bankNameEntity = $bankNameRepository->findByID(2);
echo '<b>BankNameEntity by ID:</b>';
var_dump($bankNameEntity);

$bankNameEntity = $bankNameRepository->findByBankName('Demo-Bankname');
echo '<b>BankNameEntity by BankName:</b>';
var_dump($bankNameEntity);

$bankNameRepository->createOrUpdate($bankNameEntity);
$bankNameEntity = $bankNameRepository->findByID($bankNameEntity->getId());
echo '<b>BankNameEntity by ID nach Update:</b>';
var_dump($bankNameEntity);

$bankNameEntities = $bankNameRepository->findAll();
echo '<b>All BankNameEntity:</b>';
var_dump($bankNameEntities);


/**
 * BANKNAME
 */
$bankCodeRepository = new PDOBankCodeRepository($pdo);
developTools::createDemoBankCode($bankCodeRepository);
$bankCodeEntity = $bankCodeRepository->findByID(1);
echo '<b>BankCodeEntity by ID:</b>';
var_dump($bankCodeEntity);

$bankCodeEntity = $bankCodeRepository->findByBankCode('95070724');
echo '<b>BankCodeEntity by BankCode:</b>';
var_dump($bankCodeEntity);

$bankCodeEntity = $bankCodeRepository->findByBIC('ABCDEF');
echo '<b>BankCodeEntity by BIC:</b>';
var_dump($bankCodeEntity);

$bankCodeEntity = $bankCodeRepository->findByBankName('Demo-Bankname');
echo '<b>BankCodeEntity by BankName:</b>';
var_dump($bankCodeEntity);

$bankCodeEntity = $bankCodeRepository->findAll();
echo '<b>BankCodeEntity by FindAll:</b>';
var_dump($bankCodeEntity);

$bankCodeEntity = $bankCodeRepository->findAllByRange(0,1);
echo '<b>BankCodeEntity by FindAllByRange:</b>';
var_dump($bankCodeEntity);

/**
 * BANKACCOUNTTYP
 */
$bankAccountTypRepository = new PDOBankAccountTypRepository($pdo);
developTools::createDemoBankAccountTyp($bankAccountTypRepository);
$bankAccountTypEntity = $bankAccountTypRepository->findByID(1);
echo '<b>BankAccountTypEntity by ID:</b>';
var_dump($bankAccountTypEntity);
$bankAccountTypEntity = $bankAccountTypRepository->findByBankAccountTypName('Demo-BankAccountTyp');
echo '<b>BankAccountTypEntity by BankAccountTypName:</b>';
var_dump($bankAccountTypEntity);
$bankAccountTypEntity = $bankAccountTypRepository->findAll();
echo '<b>BankCodeEntity by FindAll:</b>';
var_dump($bankAccountTypEntity);
$bankAccountTypEntity = $bankAccountTypRepository->findAllByRange(0, 1);
echo '<b>BankCodeEntity by FindAllByRange:</b>';
var_dump($bankAccountTypEntity);

/**
 * DEMO-BANKINSTITUT
 */
$bankInstitutRepository = new PDOBankInstitutRepository($pdo);
developTools::createDemoBankInstitut($bankInstitutRepository);
$bankInstitutEntity = $bankInstitutRepository->findByID(1);
echo '<b>BankInstitutEntity by ID:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByBankName('Demo-Bankname');
echo '<b>BankInstitutEntity by BankName:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByBankCode('95070724');
echo '<b>BankInstitutEntity by BankCode:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByBic('ABCDEF');
echo '<b>BankInstitutEntity by bic:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByCityName('Demo-Stadt');
echo '<b>BankInstitutEntity by CityName:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByZipCode('12345');
echo '<b>BankInstitutEntity by zipCode:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByStreet('Demostrasse');
echo '<b>BankInstitutEntity by street:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByHouseNumber('29A');
echo '<b>BankInstitutEntity by HouseNumber:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByPhone('1234512541351');
echo '<b>BankInstitutEntity by Phone:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByFax('0320429083741');
echo '<b>BankInstitutEntity by Fax:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByEmail('demo@exdrals.de');
echo '<b>BankInstitutEntity by E-Mail:</b>';
var_dump($bankInstitutEntity);
$bankInstitutEntity = $bankInstitutRepository->findByWebsite('demo.exdrals.de');
echo '<b>BankInstitutEntity by Website:</b>';
var_dump($bankInstitutEntity);