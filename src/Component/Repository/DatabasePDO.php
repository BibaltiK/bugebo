<?php

declare(strict_types=1);

namespace Exdrals\Bugebo\Component\Repository;
use Exdrals\Bugebo\Component\Exception\{FileNotFoundException,
                                         RouteNotFoundException,
                                         UnexpectedContentException
    };
use Exdrals\Bugebo\Component\Repository\Database;


class DatabasePDO extends \PDO implements Database
{

    public function __construct(array $databaseConfig)
    {
        $dsn = sprintf("mysql:host=%s;dbname=%s;charset=%s", $databaseConfig['host'],$databaseConfig['database'],$databaseConfig['charset']);
        parent::__construct($dsn,$databaseConfig['username'], $databaseConfig['password']);
    }
}
