<?php


namespace Enan\PathaoCourier\DataDTO;


use Enan\PathaoCourier\Requests\PathaoStoreRequest;


class PathaoStoreDataDTO
{
    public function fromStoreRequest(PathaoStoreRequest $request)
    {
        return [
            'name' => $request['name'],
            'contact_name' => $request['contact_name'],
            'contact_number' => $request['contact_number'],
            'address' => $request['address'],
            'city_id' => $request['city_id'],
            'zone_id' => $request['zone_id'],
            'area_id' => $request['area_id'],
        ];
    }
}
