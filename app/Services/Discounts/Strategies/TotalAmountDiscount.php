<?php

namespace App\Services\Discounts\Strategies;

use App\Models\Order;

class TotalAmountDiscount implements DiscountStrategyInterface
{
    /**
     * Apply discount to the order
     *
     * @param Order $order
     * @param float $subtotal The current subtotal after applying previous discounts
     * @return array|null Returns discount details or null if the discount is not applicable
     */
    public function apply(Order $order, float $subtotal): ?array
    {
        // Apply 10% discount if the total is 1000 TL or more
        if ($subtotal >= 1000) {
            $discountAmount = round($subtotal * 0.1, 2);
            $newSubtotal = $subtotal - $discountAmount;

            return [
                'discountReason' => $this->getReason(),
                'discountAmount' => (string) $discountAmount,
                'subtotal' => (string) $newSubtotal
            ];
        }

        return null;
    }

    /**
     * Get the reason for the discount
     *
     * @return string
     */
    public function getReason(): string
    {
        return '10_PERCENT_OVER_1000';
    }
}
