<?php

namespace App\Repositories;

interface CustomerRepositoryInterface extends RepositoryInterface
{
    /**
     * Get customer with orders
     *
     * @param int $id
     * @return mixed
     */
    public function findWithOrders(int $id): mixed;

    /**
     * Update customer revenue
     *
     * @param int $id
     * @param float $amount
     * @return bool
     */
    public function updateRevenue(int $id, float $amount): bool;
}
