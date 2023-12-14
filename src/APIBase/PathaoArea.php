<?php


namespace Enan\PathaoCourier\APIBase;


use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Enan\PathaoCourier\Services\DataServiceOutput;
use Enan\PathaoCourier\APIBase\PathaoBaseAPI;


class PathaoArea extends PathaoBaseAPI
{
    /**
     * Get All Cities
     *
     * @return mixed
     */
    public function get_cities()
    {
        $url = "aladdin/api/v1/countries/1/city-list";
        $API_response = $this->Pathao_API_Response(true, $url, Request::METHOD_GET);

        $data = Arr::get($API_response, 'data.data') ?: [];
        $message = Arr::get($API_response, 'data.message') ?: null;
        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $status_code = Arr::get($API_response, 'data.code') ?: [];

        return new DataServiceOutput($data, $message, $is_success, $status_code);
    }

    /**
     * Get All Zones Of A Selected City
     *
     * @param int $city_id
     * @return mixed
     */
    public function get_zones(int $city_id)
    {
        $url = "aladdin/api/v1/cities/" . $city_id . "/zone-list";
        $API_response = $this->Pathao_API_Response(true, $url, Request::METHOD_GET);

        $data = Arr::get($API_response, 'data.data') ?: [];
        $message = Arr::get($API_response, 'data.message') ?: null;
        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $status_code = Arr::get($API_response, 'data.code') ?: [];

        return new DataServiceOutput($data, $message, $is_success, $status_code);
    }

    /**
     * Get all areas
     *
     * @param int $zone_id
     * @return mixed
     */
    public function get_areas(int $zone_id)
    {
        $url = "aladdin/api/v1/zones/" . $zone_id . "/area-list";
        $API_response = $this->Pathao_API_Response(true, $url, Request::METHOD_GET);

        $data = Arr::get($API_response, 'data.data') ?: [];
        $message = Arr::get($API_response, 'data.message') ?: null;
        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $status_code = Arr::get($API_response, 'data.code') ?: [];

        return new DataServiceOutput($data, $message, $is_success, $status_code);
    }
}
