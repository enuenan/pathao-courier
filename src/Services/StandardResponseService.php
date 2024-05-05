<?php

namespace Enan\PathaoCourier\Services;

class StandardResponseService
{
    /**
     * This will standardize the data for output
     * @param mixed $response
     * @return array
     */
    public static function RESPONSE_OUTPUT($response): array
    {
        return [
            'data' => $response->getData(),
            'message' => $response->getMessage(),
            'status' => $response->getStatusCode(),
        ];
    }
}
