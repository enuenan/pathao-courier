<?php


namespace Enan\PathaoCourier\Requests;

use Enan\PathaoCourier\Requests\BasePathaoRequest;


class PathaoAccessTokenRequest extends BasePathaoRequest
{
    public function rules()
    {
        return [
            "client_id" => [
                "required",
                "string"
            ],
            "client_secret" => [
                "required",
                "string"
            ],
            "username" => [
                "required",
                "string"
            ],
            "password" => [
                "required",
                "string"
            ],
            "grant_type" => [
                "required",
                "string",
                "in:" . config('pathao-courier.pathao_grant_type_password')
            ],
        ];
    }
}
