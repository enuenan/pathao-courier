<?php


namespace Enan\PathaoCourier\Requests;


class PathaoStoreRequest extends BasePathaoRequest
{
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'contact_name' => [
                'required',
                'string'
            ],
            'contact_number' => [
                'required',
                'string',
                'regex:/^(?:\+880|880|01[3-9])\d{8}$/'
            ],
            'address' => [
                'required',
                'string'
            ],
            'city_id' => [
                'required',
                'numeric'
            ],
            'zone_id' => [
                'required',
                'numeric'
            ],
            'area_id' => [
                'required',
                'numeric'
            ],
        ];
    }
}
