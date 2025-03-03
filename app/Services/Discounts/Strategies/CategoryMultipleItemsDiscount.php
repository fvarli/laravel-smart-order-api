<?php

namespace App\Services\Discounts\Strategies;

use App\Models\Order;

class CategoryMultipleItemsDiscount implements DiscountStrategyInterface
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
        // Group items by product's category
        $categoryItems = [];

        foreach ($order->items as $item) {
            $categoryId = $item->product->category_id;

            if (!isset($categoryItems[$categoryId])) {
                $categoryItems[$categoryId] = [];
            }

            $categoryItems[$categoryId][] = $item;
        }

        // Check category 1 for "2 or more items, cheapest gets 20% discount"
        if (isset($categoryItems[1]) && count($categoryItems[1]) >= 2) {
            // Find the cheapest product in category 1
            $cheapestItem = null;
            $lowestTotal = PHP_FLOAT_MAX;

            foreach ($categoryItems[1] as $item) {
                if ($item->unit_price < $lowestTotal) {
                    $cheapestItem = $item;
                    $lowestTotal = $item->unit_price;
                }
            }

            if ($cheapestItem) {
                $discountAmount = round($cheapestItem->unit_price * $cheapestItem->quantity * 0.2, 2);
                $newSubtotal = $subtotal - $discountAmount;

                return [
                    'discountReason' => $this->getReason(),
                    'discountAmount' => (string) $discountAmount,
                    'subtotal' => (string) $newSubtotal
                ];
            }
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
        return 'CATEGORY_1_20_PERCENT_OFF';
    }
}
