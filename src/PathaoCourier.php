<?php


namespace Enan\PathaoCourier;


use Enan\PathaoCourier\APIBase\PathaoAuth;
use Enan\PathaoCourier\Services\StandardResponseService;


class PathaoCourier
{
    public static function GET_ACCESS_TOKEN_EXPIRY_DAYS_LEFT()
    {
        return StandardResponseService::RESPONSE_OUTPUT((new PathaoAuth)->getAccessTokenExpiryDaysLeft());
    }
}
