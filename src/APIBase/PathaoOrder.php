<?php


namespace Enan\PathaoCourier\APIBase;


use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Enan\PathaoCourier\APIBase\PathaoBaseAPI;
use Enan\PathaoCourier\Services\DataServiceOutput;


class PathaoOrder extends PathaoBaseAPI
{
    /**
     * Create Order
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create_order(array $data)
    {
        $url = "aladdin/api/v1/orders";
        $API_response = $this->Pathao_API_Response(true, $url, Request::METHOD_POST, $data);

        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $message = Arr::get($API_response, 'data.message') ?: null;

        if ($is_success) {
            $data = Arr::get($API_response, 'data') ?: [];
        } else {
            $data = Arr::get($API_response, 'data.errors') ?: [];
        }

        return new DataServiceOutput($data, $message, $is_success);
    }

    /**
     * View Order
     *
     * @param int $consignment_id
     *
     * @return mixed
     */
    public function view_order(string $consignment_id)
    {
        $url = "aladdin/api/v1/orders/" . $consignment_id;
        $API_response = $this->Pathao_API_Response(true, $url, Request::METHOD_GET);

        $data = Arr::get($API_response, 'data.data') ?: [];
        $message = Arr::get($API_response, 'data.message') ?: null;
        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $status_code = Arr::get($API_response, 'data.code') ?: [];

        return new DataServiceOutput($data, $message, $is_success, $status_code);
    }

    public function price_calculation(array $data)
    {
        $url = "aladdin/api/v1/merchant/price-plan";
        $API_response = $this->Pathao_API_Response(true, $url, Request::METHOD_POST, $data);

        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $message = Arr::get($API_response, 'data.message') ?: null;
        $status_code = Arr::get($API_response, 'data.code') ?: [];

        if ($is_success) {
            $data = Arr::get($API_response, 'data') ?: [];
        } else {
            $data = Arr::get($API_response, 'data.errors') ?: [];
        }

        return new DataServiceOutput($data, $message, $is_success, $status_code);
    }
}
