<?php

namespace App\Repositories;

interface OrderRepositoryInterface extends RepositoryInterface
{
    /**
     * Get order with its items and customer
     *
     * @param int $id
     * @return mixed
     */
    public function findWithRelations(int $id): mixed;

    /**
     * Get all orders with their items and customers
     *
     * @return mixed
     */
    public function getAllWithRelations(): mixed;
}
