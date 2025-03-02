<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    /**
     * OrderRepository constructor.
     *
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    /**
     * Get order with its items and customer
     *
     * @param int $id
     * @return Builder|Model
     */
    public function findWithRelations(int $id): Builder|Model
    {
        return $this->model->with(['items.product', 'customer'])->where('id', $id)->firstOrFail();
    }

    /**
     * Get all orders with their items and customers
     *
     * @return array|Collection
     */
    public function getAllWithRelations(): array|Collection
    {
        return $this->model->with(['items.product', 'customer'])->get();
    }
}
