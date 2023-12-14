<?php

namespace Enan\PathaoCourier\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class StandardResponseService
{
    /**
     * This will standardize the data for output
     * @param mixed $response
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public static function RESPONSE_OUTPUT($response): JsonResponse
    {
        return response()->json([
            'data' => $response->getData(),
            'message' => $response->getMessage(),
            'status' => $response->getStatusCode(),
        ], $response->getStatusCode());
    }
}
