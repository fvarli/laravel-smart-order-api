<?php

namespace App\Repositories;

interface ProductRepositoryInterface extends RepositoryInterface
{
    /**
     * Get product with its category
     *
     * @param int $id
     * @return mixed
     */
    public function findWithCategory(int $id): mixed;

    /**
     * Check if product has enough stock
     *
     * @param int $id
     * @param int $quantity
     * @return bool
     */
    public function hasEnoughStock(int $id, int $quantity): bool;

    /**
     * Update product stock
     *
     * @param int $id
     * @param int $quantity
     * @return bool
     */
    public function updateStock(int $id, int $quantity): bool;

    /**
     * Get products by category
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getByCategory(int $categoryId): mixed;
}
