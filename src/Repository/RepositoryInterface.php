<?php

namespace Flowup\ECommerce\Repository;

interface RepositoryInterface {
    public function find(int $id): ?object; // Get by id
    public function findAll(): array;      // Get all 
    public function save(object $entity): int; // save
    public function update(object $entity): void; // update
    public function delete(int $id): void; // delete
}
 