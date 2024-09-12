<?php


namespace Enan\PathaoCourier\APIBase;


use Illuminate\Support\Arr;
use Enan\PathaoCourier\APIBase\PathaoBaseAPI;
use Symfony\Component\HttpFoundation\Request;
use Enan\PathaoCourier\Services\DataServiceOutput;


class PathaoUserSuccess extends PathaoBaseAPI
{
    /**
     * Get User Success Rate
     *
     * @return mixed
     */
    public function get_user_success_rate(array $data)
    {
        $url = "api/v1/user/success";
        $API_response = $this->Pathao_API_Response(true, $url, Request::METHOD_POST, $data, true);

        $data = Arr::get($API_response, 'data.data') ?: [];
        $message = Arr::get($API_response, 'data.message') ?: null;
        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $status_code = Arr::get($API_response, 'data.code') ?: [];

        return new DataServiceOutput($data, $message, $is_success, $status_code);
    }
}
