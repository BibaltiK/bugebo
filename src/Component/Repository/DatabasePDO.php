<?php

declare(strict_types=1);

namespace Exdrals\Excidia\Component\Repository;
use Exdrals\Excidia\Component\Exception\{FileNotFoundException, 
                                         RouteNotFoundException,
                                         UnexpectedContentException
    };
use \Exdrals\Excidia\Component\Interfaces\Database;


class DatabasePDO extends \PDO implements Database
{

    public function __construct(array $databaseConfig)
    {
        $dsn = sprintf("mysql:host=%s;dbname=%s;charset=%s", $databaseConfig['host'],$databaseConfig['database'],$databaseConfig['charset']);
        parent::__construct($dsn,$databaseConfig['username'], $databaseConfig['password']);
    }
}
