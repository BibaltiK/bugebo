<?php

declare(strict_types=1);

namespace Exdrals\Excidia\Component\Repository;
use Exdrals\Excidia\Component\Exception\{FileNotFoundException, 
                                         RouteNotFoundException,
                                         UnexpectedContentException
    };

class DatabasePDO extends \PDO {
    
    protected array $databaseConfig;


    public function __construct(string $configFile) 
    {
        $this->databaseConfig = [];
        $this->setDatabaseConfig($configFile);
        $dsn = sprintf("mysql:host=%s;dbname=%s;charset=%s", $this->databaseConfig['host'],$this->databaseConfig['database'],$this->databaseConfig['charset']);
        parent::__construct($dsn,$this->databaseConfig['username'], $this->databaseConfig['password']);        
    }
    
    protected function setDatabaseConfig(string $configFile) : void
    {
        if (!$this->existsConfigFile($configFile))
            throw new FileNotFoundException (sprintf('File: %s not found.',$configFile));
        
        $databaseConfig = parse_ini_file($configFile, false, INI_SCANNER_TYPED);
        
        if (!is_array($databaseConfig))
            throw new UnexpectedContentException (sprintf('Databaseconfig must be array or null'));
        
        $this->databaseConfig = $databaseConfig;
    }
    
    protected function existsConfigFile(string $configFile) : bool
    {
        if ((!is_file($configFile))  || (!is_readable($configFile)))
        {
            return false;
        }            
        return true;
    }
}
