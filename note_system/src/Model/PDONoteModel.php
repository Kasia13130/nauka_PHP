<?php

declare(strict_types=1);

namespace Note\Model;

use Note\Exception\StorageException;
use Note\Exception\NotFoundException;
use PDO;
use Throwable;

class PDONoteModel extends AbstractDatabaseModel implements ModelInterface
{
    public function create(array $noteCreateData): void
    {
        try {
            $title = $this->connect->quote($noteCreateData['title']);
            $descripiton = $this->connect->quote($noteCreateData['description']);
            $createdDate = $this->connect->quote(date('Y-m-d H:i:s'));

            $sqlQuery = "INSERT INTO note_system.notes (title, description, create_date) 
                            VALUES ($title, $descripiton, $createdDate)";

            $this->connect->exec($sqlQuery);
        } catch (Throwable $e) {
            throw new StorageException('Utoworzenie nowej notatki się nie powiodło.', 400, $e);
            exit;
        }
    }

    public function get(int $id): array
    {
        try {
            $sqlQuery = "SELECT * FROM note_system.notes WHERE id=$id";

            $result = $this->connect->query($sqlQuery);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Błąd przy wyświetleniu notatki', 400, $e);
        }

        if (!$note) {
            throw new NotFoundException("Notatka o takim id: $id nie istnieje.");
            exit('Brak takiej notatki');
        }
        return $note;
    }

    public function list(int $pageNumber, int $pageSize, string $bySort, string $orderSort): array
    {
        return $this->findNoteBy(null, $pageNumber, $pageSize, $bySort, $orderSort);
    }

    public function search(string $searchPhrase, int $pageNumber, int $pageSize, string $bySort, string $orderSort): array
    {
        return $this->findNoteBy($searchPhrase, $pageNumber, $pageSize, $bySort, $orderSort);
    } 

    public function searchCount(string $searchPhrase): int
    {
        try {
            $searchPhrase = $this->connect->quote('%' . $searchPhrase . '%', PDO::PARAM_STR);

            $sqlQuery = "SELECT count(*) 
                         AS count 
                         FROM note_system.notes 
                         WHERE title 
                         LIKE ($searchPhrase)";

            $result = $this->connect->query($sqlQuery);
            $result = $result->fetch(PDO::FETCH_ASSOC);

            if ($result === false) {
                throw new StorageException('Błąd przy wyszukaniu całkowitej ilości notatek');
            }
            return (int) $result['count'];
        } catch (Throwable $e) {
            throw new StorageException("Nie wyszukano całkowitej ilości notatek", 400, $e);
        }
    }

    public function count(): int
    {
        try {
            $sqlQuery = "SELECT count(*) AS count FROM note_system.notes";

            $result = $this->connect->query($sqlQuery);
            $result = $result->fetch(PDO::FETCH_ASSOC);

            if ($result === false) {
                throw new StorageException('Błąd przy pobieraniu całkowitej ilości notatek');
            }
            return (int) $result['count'];
        } catch (Throwable $e) {
            throw new StorageException("Nie pobrano całkowitej ilości notatek", 400, $e);
        }
    }

    public function edit(int $idNote, array $editedDataNote): void
    {
        try {
            $title = $this->connect->quote($editedDataNote['title']);
            $description = $this->connect->quote($editedDataNote['description']);

            $sqlQuery = "UPDATE note_system.notes SET title = $title, description = $description WHERE id = $idNote";

            $this->connect->exec($sqlQuery);
        } catch (Throwable $e) {
            throw new StorageException('Edytowanie notatki nie powiodło się', 400, $e);
        }
    }

    public function delete(int $idNote): void
    {
        try {
            $sqlQuery = "DELETE FROM note_system.notes WHERE id = $idNote LIMIT 1";
            $this->connect->exec($sqlQuery);
        } catch (Throwable $e) {
            throw new StorageException('Notatka nie nostała usunięta', 400, $e);
        }
    }

    private function findNoteBy(?string $searchPhrase, int $pageNumber, int $pageSize, string $bySort, string $orderSort): array
    {
        try {
            $pageLimit = $pageSize;
            $pageOffset = ($pageNumber - 1) * $pageSize;

            if (!in_array($bySort, ['title', 'create_date'])) {
                $bySort = 'title';
            }

            if (!in_array($orderSort, ['asc', 'desc'])) {
                $orderSort = 'desc';
            }

            $searchingPartQuery = '';
            if ($searchPhrase) {
                $searchPhrase = $this->connect->quote('%' . $searchPhrase . '%', PDO::PARAM_STR);
                $searchingPartQuery = "WHERE title LIKE ($searchPhrase)";
            }

            $sqlQuery = "SELECT id, title, create_date 
                         FROM note_system.notes 
                         $searchingPartQuery
                         ORDER BY $bySort $orderSort 
                         LIMIT $pageOffset, $pageLimit";

            $result = $this->connect->query($sqlQuery);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException("Nie udało się pobrać notatkek", 400, $e);
        }
    }
}
