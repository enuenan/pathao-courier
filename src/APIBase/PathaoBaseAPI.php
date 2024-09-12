<?php


namespace Enan\PathaoCourier\APIBase;

use ErrorException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\ClientException;
use Enan\PathaoCourier\Services\PathaoHelperFunction;
use Illuminate\Http\Request;


class PathaoBaseAPI
{
    // public string $base_url = config('pathao-courier.pathao_base_url');
    public string $base_url = 'https://api-hermes.pathao.com/';
    public string $merchant_base_url = 'https://merchant.pathao.com/';

    public $secret_token;
    public $table_name;
    public $pathao_token_data;


    public function __construct()
    {
        $this->secret_token = PathaoHelperFunction::getSecretToken();
        $this->table_name = PathaoHelperFunction::getTableName();

        $this->pathao_token_data = PathaoHelperFunction::getPathaoTokenData();
    }

    /**
     * This will set the headers for the api
     * It will set the authorization if the bool auth is set true
     * @param bool $auth
     * @return array
     */
    protected function setHeaders(bool $auth = false)
    {
        $headers = [
            "accept" => "application/json",
            "content-type" => 'application/json',
        ];

        if ($auth) {
            try {
                $headers["authorization"] = "Bearer " . $this->pathao_token_data->token;
            } catch (ErrorException $e) {
                Log::error($e->getMessage());
                $common_message = "READ CAREFULLY: This error is from enan/pathao-courier package.";

                if (empty(config('pathao-courier.pathao_client_id'))) {
                    throw new ErrorException($common_message . "Please update your env value with `PATHAO_CLIENT_ID`. 
                                            You can find it on the developers api -> Merchant API Credentials section in Pathao Merchant (https://merchant.pathao.com/courier/developer-api).
                                            You Have to enable it from there.");
                } else if (empty(config('pathao-courier.pathao_client_secret'))) {
                    throw new ErrorException($common_message . "Please update your env value with `PATHAO_CLIENT_SECRET`. 
                                            You can find it on the developers api -> Merchant API Credentials section in Pathao Merchant (https://merchant.pathao.com/courier/developer-api).
                                            You Have to enable it from there.");
                } else if (empty(config('pathao-courier.pathao_secret_token'))) {
                    throw new ErrorException($common_message . "Please update your env value with `PATHAO_SECRET_TOKEN`. 
                                            This value was provided to you while setting up the credentials. 
                                            If you miss it you can get it in the database table `" . config('pathao-courier.pathao_db_table_name') . "` column `secret_token`. 
                                            Or you can setup a new token by simply running a command `php artisan set:pathao-courier`.");
                } else {
                    throw new ErrorException($common_message . "Please check your env or database. 
                                            If the credentials is missing please setup it with running the command `php artisan set:pathao-courier`.");
                }
            }
        };

        return $headers;
    }

    /**
     * It will be used as to access the pathao api
     * It is a base funciton
     * @param bool $auth
     * @param string $api
     * @param string $method
     * @param mixed $data
     * @return array
     */
    public function Pathao_API_Response(bool $auth = false, string $api, string $method, ?array $data = [], ?bool $merchant = false)
    {
        $response = ['data' => [], 'status' => Response::HTTP_OK];

        try {
            $httpClient = Http::timeout(100)->withHeaders($this->setHeaders($auth));
            if ($merchant) {
                $httpUrl = $this->merchant_base_url . $api;
            } else {
                $httpUrl = $this->base_url . $api;
            }
            if ($method === Request::METHOD_GET) {
                $pathaoResponse = $httpClient->get($httpUrl, null);
            } else {
                $pathaoResponse = $httpClient->post($httpUrl, $data);
            }

            $dataResponse = $pathaoResponse->json();

            $response['data'] = $dataResponse;
            $response['status'] = $pathaoResponse->status();
            $response['is_success'] = $pathaoResponse->successful();

            if ($pathaoResponse->failed()) {
                $response['errors'] = Arr::get($dataResponse, 'errors');
            }
        } catch (ClientException $e) {
            $response['error'] = $e->getMessage();
            $response['status'] = Response::HTTP_BAD_REQUEST;
        }

        return $response;
    }

    /**
     * Indicates if the api status code is successful.
     * Supported status codes are:
     * 200 -> default response
     * 206 -> partial response
     *
     * @param int $statusCode
     * @return bool
     */
    public function isSuccessfulResponse(int $statusCode)
    {
        return in_array($statusCode, [Response::HTTP_OK, Response::HTTP_PARTIAL_CONTENT]);
    }
}
