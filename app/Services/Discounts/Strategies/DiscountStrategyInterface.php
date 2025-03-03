<?php

namespace App\Services\Discounts\Strategies;

use App\Models\Order;

interface DiscountStrategyInterface
{
    /**
     * Apply discount to the order
     *
     * @param Order $order
     * @param float $subtotal The current subtotal after applying previous discounts
     * @return array|null Returns discount details or null if the discount is not applicable
     */
    public function apply(Order $order, float $subtotal): ?array;

    /**
     * Get the reason for the discount
     *
     * @return string
     */
    public function getReason(): string;
}
