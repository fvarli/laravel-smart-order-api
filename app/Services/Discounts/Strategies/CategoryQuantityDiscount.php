<?php

namespace App\Services\Discounts\Strategies;

use App\Models\Order;

class CategoryQuantityDiscount implements DiscountStrategyInterface
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
        $discountAmount = 0;

        // Group items by product's category
        $categoryItems = [];

        foreach ($order->items as $item) {
            $categoryId = $item->product->category_id;

            if (!isset($categoryItems[$categoryId])) {
                $categoryItems[$categoryId] = [];
            }

            $categoryItems[$categoryId][] = $item;
        }

        // Check category 2 for "buy 5, get 1 free" discount
        if (isset($categoryItems[2])) {
            foreach ($categoryItems[2] as $item) {
                // If quantity is 6 or more, give discount for each complete set of 6
                if ($item->quantity >= 6) {
                    $freeItems = (int) ($item->quantity / 6);
                    $discountAmount += round($item->unit_price * $freeItems, 2);
                }
            }
        }

        if ($discountAmount > 0) {
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
        return 'BUY_5_GET_1';
    }
}
