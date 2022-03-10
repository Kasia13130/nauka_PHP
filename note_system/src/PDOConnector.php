<?php

declare(strict_types=1);

namespace Note;

use Note\Exception\ConfigurationException;
use Note\Exception\StorageException;
use Note\Exception\NotFoundException;
use PDO;
use PDOException;
use Throwable;

class PDOConnector
{
    private PDO $connect;

    public function __construct(array $config)
    {
        try {

            $this->configValidation($config);
            $this->createDatabaseConnection($config);    

        } catch (PDOException $e) {
            throw new StorageException('Connection error');        
        }       
    }

    public function createNote(array $noteCreateData): void
    {
        try 
        {
            $title = $this->connect->quote($noteCreateData['title']);
            $descripiton = $this->connect->quote($noteCreateData['description']);
            $createdDate = $this->connect->quote(date('Y-m-d H:i:s'));

            $sqlQuery = "INSERT INTO note_system.notes (title, description, create_date) 
                            VALUES ($title, $descripiton, $createdDate)";

            $this->connect->exec($sqlQuery);
        }
        catch (Throwable $e)
        {
            throw new StorageException('Utoworzenie nowej notatki się nie powiodło.', 400, $e);
            exit;
        }        
    }

    public function getNote(int $id): array
    {
        try
        {
            $sqlQuery = "SELECT * FROM note_system.notes WHERE id=$id";

            $result = $this->connect->query($sqlQuery);
            $note = $result->fetch(PDO::FETCH_ASSOC);            
        }
        catch (Throwable $e)
        {
            throw new StorageException('Błąd przy wyświetleniu notatki', 400, $e);
        }

        if (!$note)
        {
            throw new NotFoundException("Notatka o takim id: $id nie istnieje.");
            exit('Brak takiej notatki');
        }
        return $note;
    }

    public function getNotes(string $bySort, string $orderSort): array
    {
        try 
        {
            if (!in_array($bySort, ['title', 'create_date']))
            {
                $bySort = 'title';
            }

            if (!in_array($orderSort, ['asc', 'desc']))
            {
                $orderSort = 'desc';
            }

            $sqlQuery = "SELECT id, title, create_date FROM note_system.notes ORDER BY $bySort $orderSort";

            $result = $this->connect->query($sqlQuery);
            return $result->fetchAll(PDO::FETCH_ASSOC);           
        }
        catch (Throwable $e)
        {
            throw new StorageException("Nie pobrano informacji o notatkach", 400, $e);
        }
        
    }

    public function editNote(int $idNote, array $editedDataNote): void
    {
        try
        {
            $title = $this->connect->quote($editedDataNote['title']);
            $description = $this->connect->quote($editedDataNote['description']);

            $sqlQuery = "UPDATE note_system.notes SET title = $title, description = $description WHERE id = $idNote";
            
            $this->connect->exec($sqlQuery);
        }
        catch (Throwable $e)
        {
            throw new StorageException('Edytowanie notatki nie powiodło się', 400, $e);
        }
    }

    public function deleteNote(int $idNote): void
    {
        try 
        {
            $sqlQuery = "DELETE FROM note_system.notes WHERE id = $idNote LIMIT 1";
            $this->connect->exec($sqlQuery);
        }
        catch (Throwable $e)
        {
            throw new StorageException('Notatka nie nostała usunięta', 400, $e);
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