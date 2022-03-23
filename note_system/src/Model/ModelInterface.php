<?php

declare(strict_types=1);

namespace Note\Model;

interface ModelInterface
{
    public function list(int $pageNumber, int $pageSize, string $bySort, string $orderSort): array;

    public function search(string $searchPhrase, int $pageNumber, int $pageSize, string $bySort, string $orderSort): array;

    public function count(): int;

    public function searchCount(string $searchPhrase): int;

    public function get(int $id): array;

    public function create(array $noteCreateData): void;

    public function edit(int $idNote, array $editedDataNote): void;

    public function delete(int $idNote): void;
}