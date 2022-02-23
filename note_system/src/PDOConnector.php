<?php

declare(strict_types=1);

namespace Note;

require_once("Exception/StorageException.php");
require_once("Exception/AppException.php");

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use PDO;
use PDOException;
use Throwable;

class PDOConnector
{
    public function __construct(array $config)
    {
        try {

            $this->configValidation($config);

            $dsn = "mysql:databse={$config['database']};host={$config['host']}";
        
            $connect = new PDO($dsn, $config['user'], $config['password']); 

        } catch (PDOException $e) {
            throw new StorageException('Connection error');        
        }       
    }

    private function configValidation(array $config): void
    {
        if (!empty($config['database']) || empty($config['host']) || empty($config['user']) || empty($config['password']))
        {
            throw new ConfigurationException('Storage configuration error');
        }
    }
}