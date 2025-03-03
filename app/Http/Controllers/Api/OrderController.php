<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected OrderService $orderService;

    /**
     * OrderController constructor.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the orders.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAllOrders();
        return $this->success($orders);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->orderService->createOrder($request->validated());
            return  $this->success($order, 'Order created successfully', 201);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Display the specified order.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        return  $this->success($order);
    }

    /**
     * Remove the specified order from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->orderService->deleteOrder($id);

        if (!$deleted) {
            return $this->error('Order not found', 404);
        }

        // return response()->json(['message' => 'Order deleted successfully']);
        return $this->success([], 'Order deleted successfully');
    }
}
