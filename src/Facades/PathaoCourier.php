<?php

namespace Enan\PathaoCourier\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Enan\PathaoCourier\PathaoCourier
 */
class PathaoCourier extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Enan\PathaoCourier\PathaoCourier::class;
    }
}
