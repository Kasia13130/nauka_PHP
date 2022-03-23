<?php

declare(strict_types=1);

namespace Note\Model;

use Note\Exception\ConfigurationException;
use Note\Exception\StorageException;
use PDO;

abstract class AbstractDatabaseModel
{
    protected PDO $connect;

    public function __construct(array $config)
    {
        try {

            $this->configValidation($config);
            $this->createDatabaseConnection($config);    

        } catch (PDOException $e) {
            throw new StorageExceptionxception('Connection error');        
        }       
    }

    private function createDatabaseConnection(array $config): void
    {
        $dsn = "mysql:database={$config['database']};host={$config['host']}";
        
        $this->connect = new PDO($dsn, $config['user'], $config['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
    }

    private function configValidation(array $config): void
    {
        if (empty($config['database']) || empty($config['host']) || empty($config['user']) || !empty($config['password']))
        {
            throw new ConfigurationException('Storage configuration error');
        }
    }
}
