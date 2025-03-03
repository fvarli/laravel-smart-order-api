<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepositoryInterface;
use App\Services\Discounts\Strategies\DiscountStrategyInterface;
use Illuminate\Support\Collection;

class DiscountService
{
    /**
     * @var OrderRepositoryInterface
     */
    protected OrderRepositoryInterface $orderRepository;

    /**
     * @var Collection
     */
    protected Collection $strategies;

    /**
     * DiscountService constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param array $strategies
     */
    public function __construct(OrderRepositoryInterface $orderRepository, array $strategies = [])
    {
        $this->orderRepository = $orderRepository;
        $this->strategies = collect($strategies);
    }

    /**
     * Add a discount strategy
     *
     * @param DiscountStrategyInterface $strategy
     * @return $this
     */
    public function addStrategy(DiscountStrategyInterface $strategy): static
    {
        $this->strategies->push($strategy);

        return $this;
    }

    /**
     * Calculate discounts for an order
     *
     * @param int $orderId
     * @return array
     */
    public function calculateDiscounts(int $orderId): array
    {
        $order = $this->orderRepository->findWithRelations($orderId);

        if (!$order) {
            return [
                'error' => 'Order not found',
                'status' => 404
            ];
        }

        $discounts = [];
        $subtotal = (float) $order->total;
        $totalDiscount = 0;

        // Apply each strategy and collect discounts
        foreach ($this->strategies as $strategy) {
            $discount = $strategy->apply($order, $subtotal);

            if ($discount) {
                $discounts[] = $discount;
                $subtotal = (float) $discount['subtotal'];
                $totalDiscount += (float) $discount['discountAmount'];
            }
        }

        return [
            'orderId' => $order->id,
            'discounts' => $discounts,
            'totalDiscount' => (string) round($totalDiscount, 2),
            'discountedTotal' => (string) round($subtotal, 2)
        ];
    }
}
