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
    /**
     * Usage: PathaoCourier::GET_ACCESS_TOKEN_EXPIRY_DAYS_LEFT()
     * 
     * This will return the remaining days left for access token
     * And also return the expected last date of the access token expiration
     * 
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function GET_ACCESS_TOKEN_EXPIRY_DAYS_LEFT()
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoAuth)->getAccessTokenExpiryDaysLeft());
    }

    /**
     * Usage: PathaoCourier::GET_CITIES()
     * 
     * This will return the city list
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function GET_CITIES()
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoArea)->get_cities());
    }

    /**
     * Usage: PathaoCourier::GET_ZONES($city_id)
     * 
     * This will return the zone list under a city
     * @param int $city_id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function GET_ZONES(int $city_id)
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoArea)->get_zones($city_id));
    }

    /**
     * Usage: PathaoCourier::GET_AREAS($zone_id)
     * 
     * This will return the area list under a zone
     * @param int $zone_id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function GET_AREAS(int $zone_id)
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoArea)->get_areas($zone_id));
    }

    /**
     * Usage: PathaoCourier::GET_STORES()
     * 
     * This will return the store list
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function GET_STORES(int $page = 1)
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoStore)->get_stores($page));
    }

    /**
     * Usage: PathaoCourier::CREATE_STORE($request)
     * 
     * This will create a store in Pathao courier merchant
     * @param \Enan\PathaoCourier\Requests\PathaoStoreRequest $request
     * 
     * Request parameters are below and will follow a validation
     * @param $name <required, string>
     * @param $contact_name <required, string>
     * @param $contact_number <required, numeric>
     * @param $address <required, string>
     * @param $city_id <required, numeric>
     * @param $zone_id <required, numeric>
     * @param $area_id <required, numeric>
     * 
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function CREATE_STORE(PathaoStoreRequest $request)
    {
        $pathaoOrderDto = ((new PathaoStoreDataDTO)->fromStoreRequest($request));
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoStore)->create_store($pathaoOrderDto));
    }

    /**
     * Usage: PathaoCourier::VIEW_ORDER($consignment_id)
     * 
     * This will fetch the details of a order
     * @param string $consignment_id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function VIEW_ORDER(string $consignment_id)
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoOrder)->view_order($consignment_id));
    }

    /**
     * Usage: PathaoCourier::CREATE_ORDER($request)
     * 
     * This will create a order in Pathao courier merchant
     * @param \Enan\PathaoCourier\Requests\PathaoOrderRequest $request
     * 
     * Request parameters are below and will follow a validation
     * @param $store_id <required, numeric>
     * @param $merchant_order_id <nullable, string>
     * @param $sender_name <required, numeric>
     * @param $sender_phone <required, string/>
     * @param $recipient_name <required, string>
     * @param $recipient_phone <required, string>
     * @param $recipient_address <required, string, Min:10>
     * @param $recipient_city <required, numeric>
     * @param $recipient_zone <required, numeric>
     * @param $recipient_area <required, numeric>
     * @param $delivery_type <required, numeric> is provided by the merchant and not changeable. 48 for Normal Delivery, 12 for On Demand Delivery"
     * @param $item_type <required, numeric> is provided by the merchant and not changeable. 1 for Document, 2 for Parcel"
     * @param $special_instruction <nullable, string>
     * @param $item_quantity <required, numeric>
     * @param $item_weight <required, numeric>
     * @param $amount_to_collect <required, numeric>
     * @param $item_description <nullable, string>
     * 
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function CREATE_ORDER(PathaoOrderRequest $request)
    {
        $pathaoOrderDto = ((new PathaoOrderDTO)->fromOrderRequest($request));
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoOrder)->create_order($pathaoOrderDto));
    }

    /**
     * Usage: PathaoCourier::GET_PRICE_CALCULATION($request)
     * 
     * This will return the calculated price for a order
     * @param \Enan\PathaoCourier\Requests\PathaoOrderPriceCalculationRequest $request
     *
     * Request parameters are below and will follow a validation
     * @param $delivery_type <required, numeric>
     * @param $item_type <required, numeric>
     * @param $item_weight <required, numeric>
     * @param $recipient_city <required, numeric>
     * @param $recipient_zone <required, numeric>
     * @param $store_id <required, numeric>
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function GET_PRICE_CALCULATION(PathaoOrderPriceCalculationRequest $request)
    {
        $priceCalculationDTO = (new PathaoOrderDTO)->fromPriceCalculationRequest($request);
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoOrder)->price_calculation($priceCalculationDTO));
    }
}
