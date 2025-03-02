<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * ProductRepository constructor.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * Get product with its category
     *
     * @param int $id
     * @return mixed
     */
    public function findWithCategory(int $id): mixed
    {
        return $this->model->with('category')->find($id);
    }

    /**
     * Check if product has enough stock
     *
     * @param int $id
     * @param int $quantity
     * @return bool
     */
    public function hasEnoughStock(int $id, int $quantity): bool
    {
        $product = $this->find($id);

        return $product && $product->stock >= $quantity;
    }

    /**
     * Update product stock
     *
     * @param int $id
     * @param int $quantity
     * @return bool
     */
    public function updateStock(int $id, int $quantity): bool
    {
        return DB::transaction(function () use ($id, $quantity) {
            $product = $this->find($id);

            if (!$product) {
                return false;
            }

            $product->stock -= $quantity;
            return $product->save();
        });
    }

    /**
     * Get products by category
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getByCategory(int $categoryId): mixed
    {
        return $this->model->where('category_id', $categoryId)->get();
    }
}
