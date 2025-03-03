<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse {
    /**
     * @param $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function success($data, string $message = "Success", int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function error(string $message = "Error", int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $status);
    }
}
