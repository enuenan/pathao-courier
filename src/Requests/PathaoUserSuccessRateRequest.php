<?php


namespace Enan\PathaoCourier\Requests;


class PathaoUserSuccessRateRequest extends BasePathaoRequest
{
    public function rules()
    {
        return [
            'phone' => [
                'required',
                'string',
                'regex:/^(?:\+880|880|01[3-9])\d{8}$/'
            ],
        ];
    }
}
