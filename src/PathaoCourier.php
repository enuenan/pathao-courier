<?php


namespace Enan\PathaoCourier;


use Enan\PathaoCourier\APIBase\PathaoArea;
use Enan\PathaoCourier\APIBase\PathaoAuth;
use Enan\PathaoCourier\APIBase\PathaoOrder;
use Enan\PathaoCourier\APIBase\PathaoStore;
use Enan\PathaoCourier\DataDTO\PathaoOrderDTO;
use Enan\PathaoCourier\DataDTO\PathaoStoreDataDTO;
use Enan\PathaoCourier\Requests\PathaoOrderRequest;
use Enan\PathaoCourier\Requests\PathaoStoreRequest;
use Enan\PathaoCourier\Services\StandardResponseService;
use Enan\PathaoCourier\Requests\PathaoOrderPriceCalculationRequest;

class PathaoCourier
{
    public static function GET_ACCESS_TOKEN_EXPIRY_DAYS_LEFT()
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoAuth)->getAccessTokenExpiryDaysLeft());
    }

    public static function GET_CITIES()
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoArea)->get_cities());
    }

    public static function GET_ZONES(int $city_id)
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoArea)->get_zones($city_id));
    }

    public static function GET_AREAS(int $zone_id)
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoArea)->get_areas($zone_id));
    }

    public static function GET_STORES(int $page = 1)
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoStore)->get_stores($page));
    }

    public static function CREATE_STORE(PathaoStoreRequest $request)
    {
        $pathaoOrderDto = ((new PathaoStoreDataDTO)->fromStoreRequest($request));
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoStore)->create_store($pathaoOrderDto));
    }

    public static function VIEW_ORDER(string $consignment_id)
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoOrder)->view_order($consignment_id));
    }

    public static function CREATE_ORDER(PathaoOrderRequest $request)
    {
        $pathaoOrderDto = ((new PathaoOrderDTO)->fromOrderRequest($request));
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoOrder)->create_order($pathaoOrderDto));
    }

    public static function GET_PRICE_CALCULATION(PathaoOrderPriceCalculationRequest $request)
    {
        $priceCalculationDTO = (new PathaoOrderDTO)->fromPriceCalculationRequest($request);
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoOrder)->price_calculation($priceCalculationDTO));
    }
}
