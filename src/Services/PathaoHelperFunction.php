<?php

namespace Enan\PathaoCourier\Services;

use Illuminate\Support\Facades\DB;


class PathaoHelperFunction
{
    public static function getTableName(): string
    {
        return config('pathao-courier.pathao_db_table_name');
    }

    public static function getSecretToken(): string
    {
        return config('pathao-courier.pathao_secret_token');
    }

    public static function getPathaoTokenData(): ?object
    {
        return DB::table(self::getTableName())
            ->select('*')
            ->where('secret_token', '=', self::getSecretToken())
            ->first();
    }
}
