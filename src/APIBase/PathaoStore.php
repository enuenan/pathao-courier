<?php


namespace Enan\PathaoCourier\APIBase;


use Enan\PathaoCourier\APIBase\PathaoBaseAPI;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Enan\PathaoCourier\Services\DataServiceOutput;


class PathaoStore extends PathaoBaseAPI
{
    /**
     * This will fetch all the stores
     * @param int $page
     * @return DataServiceOutput
     */
    public function get_stores(int $page)
    {
        $url = "aladdin/api/v1/stores?page={$page}";
        $API_response = $this->Pathao_API_Response(true, $url, Request::METHOD_GET);

        $data = Arr::get($API_response, 'data.data') ?: [];
        $message = Arr::get($API_response, 'data.message') ?: null;
        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $status_code = Arr::get($API_response, 'data.code') ?: [];

        return new DataServiceOutput($data, $message, $is_success, $status_code);
    }

    /**
     * This will create a new store
     * @param array $cred
     * @return DataServiceOutput
     */
    public function create_store(array $cred)
    {
        $url = "aladdin/api/v1/stores";
        $API_response = $this->Pathao_API_Response(true, $url, Request::METHOD_POST, $cred);

        $data = Arr::get($API_response, 'data.data') ?: [];
        $message = Arr::get($API_response, 'data.message') ?: null;
        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $status_code = Arr::get($API_response, 'data.code') ?: [];

        return new DataServiceOutput($data, $message, $is_success, $status_code);
    }
}
