<?php


namespace Enan\PathaoCourier\DataDTO;


use Enan\PathaoCourier\Requests\PathaoOrderRequest;
use Enan\PathaoCourier\Requests\PathaoOrderPriceCalculationRequest;


class PathaoOrderDTO
{
    public function fromOrderRequest(PathaoOrderRequest $request)
    {
        return [
            "store_id" => $request['store_id'],
            "merchant_order_id" => $request['merchant_order_id'],
            "sender_name" => $request['sender_name'],
            "sender_phone" => $request['sender_phone'],
            "recipient_name" => $request['recipient_name'],
            "recipient_phone" => $request['recipient_phone'],
            "recipient_address" =>  $request['recipient_address'],
            "recipient_city" => $request['recipient_city'],
            "recipient_zone" => $request['recipient_zone'],
            "recipient_area" => $request['recipient_area'],
            "delivery_type" => $request['delivery_type'],
            "item_type" => $request['item_type'],
            "special_instruction" => $request['special_instruction'],
            "item_quantity" =>  $request['item_quantity'],
            "item_weight" => $request['item_weight'],
            "amount_to_collect" => $request['amount_to_collect'],
            "item_description" => $request['item_description'],
        ];
    }

    public function fromPriceCalculationRequest(PathaoOrderPriceCalculationRequest $request)
    {
        return [
            "delivery_type" => $request['delivery_type'],
            "item_type" => $request['item_type'],
            "item_weight" => $request['item_weight'],
            "recipient_city" => $request['recipient_city'],
            "recipient_zone" => $request['recipient_zone'],
            "store_id" => $request['store_id'],
        ];
    }
}
