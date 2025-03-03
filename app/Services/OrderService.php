<?php

namespace App\Services;

use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    /**
     * @var OrderRepositoryInterface
     */
    protected OrderRepositoryInterface $orderRepository;

    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected CustomerRepositoryInterface $customerRepository;

    /**
     * OrderService constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param ProductRepositoryInterface $productRepository
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Get all orders
     *
     * @return mixed
     */
    public function getAllOrders(): mixed
    {
        return $this->orderRepository->getAllWithRelations();
    }

    /**
     * Get order by id
     *
     * @param int $id
     * @return mixed
     */
    public function getOrderById(int $id): mixed
    {
        return $this->orderRepository->findWithRelations($id);
    }

    /**
     * Create a new order
     *
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function createOrder(array $data): mixed
    {
        return DB::transaction(function () use ($data) {
            // Check if the customer exists
            $customer = $this->customerRepository->find($data['customer_id']);

            if (!$customer) {
                throw ValidationException::withMessages([
                    'customer_id' => 'The selected customer does not exist.'
                ]);
            }

            // Check if all products have enough stock
            foreach ($data['items'] as $item) {
                if (!$this->productRepository->hasEnoughStock($item['product_id'], $item['quantity'])) {
                    $product = $this->productRepository->find($item['product_id']);
                    throw ValidationException::withMessages([
                        'items' => "The product '{$product->name}' does not have enough stock."
                    ]);
                }
            }

            // Create the order
            $order = $this->orderRepository->create([
                'customer_id' => $data['customer_id'],
                'total' => 0
            ]);

            $total = 0;

            // Create order items
            foreach ($data['items'] as $itemData) {
                $product = $this->productRepository->find($itemData['product_id']);

                $unitPrice = $product->price;
                $quantity = $itemData['quantity'];
                $itemTotal = $unitPrice * $quantity;

                $order->items()->create([
                    'product_id' => $itemData['product_id'],
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total' => $itemTotal
                ]);

                // Update product stock
                $this->productRepository->updateStock($itemData['product_id'], $quantity);

                $total += $itemTotal;
            }

            // Update order total
            $order->update(['total' => $total]);

            // Update customer revenue
            $this->customerRepository->updateRevenue($data['customer_id'], $total);

            return $this->orderRepository->findWithRelations($order->id);
        });
    }

    /**
     * Delete an order
     *
     * @param int $id
     * @return bool
     */
    public function deleteOrder(int $id): bool
    {
        return $this->orderRepository->delete($id);
    }
}
