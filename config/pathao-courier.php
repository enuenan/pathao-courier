<?php

// config for Enan/PathaoCourier
return [

    /*
    |--------------------------------------------------------------------------
    | Pathao DB Table Name
    |--------------------------------------------------------------------------
    |
    | The migration file is using this table name. If you provide the name
    | in .env it will use that name otherwise it will use the default name
    | 'pathao-courier'. If you wish to change the name of migration. Remember 
    | to update it before migration.
    |
    */
    'pathao_db_table_name' => env('PATHAO_DB_TABLE_NAME', 'pathao-courier'),


    /*
    |--------------------------------------------------------------------------
    | Pathao Base Url
    |--------------------------------------------------------------------------
    |
    | This is the base url for the Pathao Courier
    |
    */
    'pathao_base_url' => 'https://api-hermes.pathao.com/', // Don't change it


    /*
    |--------------------------------------------------------------------------
    | Pathao Client Id
    |--------------------------------------------------------------------------
    |
    | This is the Pathao Client Id. Please provide it in the .env file.
    | You can find it on the developers api -> Merchant API Credentials
    | section in Pathao Merchant (https://merchant.pathao.com/courier/developer-api).
    | You Have to enable it from there.
    |
    */
    'pathao_client_id' => env('PATHAO_CLIENT_ID', ''),


    /*
    |--------------------------------------------------------------------------
    | Pathao Client Secret
    |--------------------------------------------------------------------------
    |
    | This is the Pathao Client Secret. Please provide it in the .env file.
    | You can find it on the developers api -> Merchant API Credentials
    | section in Pathao Merchant (https://merchant.pathao.com/courier/developer-api).
    | You Have to enable it from there.
    |
    */
    'pathao_client_secret' => env('PATHAO_CLIENT_SECRET', ''),


    /*
    |--------------------------------------------------------------------------
    | Pathao Secret Token
    |--------------------------------------------------------------------------
    |
    | After successfully setup the token you will be provided a secret token.
    | Please keep it in the .env as PATHAO_SECRET_TOKEN.
    |
    */
    'pathao_secret_token' => env('PATHAO_SECRET_TOKEN', ''),


    /*
    |--------------------------------------------------------------------------
    | Pathao Grant Type Password
    |--------------------------------------------------------------------------
    |
    | This is Pathao Grant Type Password. It wiil be used as a parameter for
    | requesting new token.
    |
    */
    'pathao_grant_type_password' => 'password', // Don't change it


    /*
    |--------------------------------------------------------------------------
    | Pathao Grant Type Refresh Token
    |--------------------------------------------------------------------------
    |
    | This is Pathao Grant Type Refresh Token. It wiil be used as a parameter for
    | requesting a refresh token.
    |
    |
    */
    'pathao_grant_type_refresh_token' => 'refresh_token', // Don't change it
];
