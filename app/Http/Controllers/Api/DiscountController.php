<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DiscountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * @var DiscountService
     */
    protected DiscountService $discountService;

    /**
     * DiscountController constructor.
     *
     * @param DiscountService $discountService
     */
    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * Calculate discounts for an order.
     *
     * @param int $orderId
     * @return JsonResponse
     */
    public function calculate(int $orderId): JsonResponse
    {
        $result = $this->discountService->calculateDiscounts($orderId);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], $result['status'] ?? 400);
        }

        return response()->json($result);
    }

}
