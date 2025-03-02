<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all resources
     *
     * @return mixed
     */
    public function all(): mixed;

    /**
     * Get resource by id
     *
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed;

    /**
     * Create new resource
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Update resource
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed;

    /**
     * Delete resource
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
