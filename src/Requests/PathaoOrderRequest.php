<?php


namespace Enan\PathaoCourier\Requests;


class PathaoOrderRequest extends BasePathaoRequest
{
    const DELIVERY_TYPE_NORMAL = 48;
    const DELIVERY_TYPE_DEMAND = 12;
    const ITEM_TYPE_DOCUMENT = 1;
    const ITEM_TYPE_PARCEL = 2;


    public function rules()
    {
        return [
            'store_id' => [
                'required',
                'numeric'
            ],
            'merchant_order_id' => [
                'nullable',
                'string'
            ],
            'sender_name' => [
                'required',
                'string'
            ],
            'sender_phone' => [
                'required',
                'string',
                'regex:/^(?:\+880|880|01[3-9])\d{8}$/'
            ],
            'recipient_name' => [
                'required',
                'string'
            ],
            'recipient_phone' => [
                'required',
                'string',
                'regex:/^(?:\+880|880|01[3-9])\d{8}$/'
            ],
            'recipient_address' => [
                'required',
                'string',
                'Min:10'
            ],
            'recipient_city' => [
                'nullable',
                'numeric'
            ],
            'recipient_zone' => [
                'nullable',
                'numeric'
            ],
            'recipient_area' => [
                'nullable',
                'numeric'
            ],
            'delivery_type' => [
                'required',
                'in:' . self::DELIVERY_TYPE_NORMAL . ',' . self::DELIVERY_TYPE_DEMAND
            ],
            'item_type' => [
                'required',
                'in:' . self::ITEM_TYPE_DOCUMENT . ',' . self::ITEM_TYPE_PARCEL
            ],
            'special_instruction' => [
                'nullable',
                'string'
            ],
            'item_quantity' => [
                'required',
                'numeric'
            ],
            'item_weight' => [
                'required',
                'numeric'
            ],
            'amount_to_collect' => [
                'required',
                'numeric'
            ],
            'item_description' => [
                'nullable',
                'string'
            ]
        ];
    }
}
