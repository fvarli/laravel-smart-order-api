<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    /**
     * CustomerRepository constructor.
     *
     * @param Customer $model
     */
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    /**
     * Get customer with orders
     *
     * @param int $id
     * @return mixed
     */
    public function findWithOrders(int $id): mixed
    {
        return $this->model->with('orders')->find($id);
    }

    /**
     * Update customer revenue
     *
     * @param int $id
     * @param float $amount
     * @return bool
     */
    public function updateRevenue(int $id, float $amount): bool
    {
        return Customer::where('id', $id)->increment('revenue', $amount);
    }
}
