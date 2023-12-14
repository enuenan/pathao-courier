<?php


namespace Enan\PathaoCourier\APIBase;


use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\ClientException;
use Enan\PathaoCourier\Services\PathaoHelperFunction;
use Illuminate\Http\Request;


class PathaoBaseAPI
{
    public string $base_url = config('pathao-courier.pathao_base_url');
    // public string $base_url = 'https://api-hermes.pathao.com/';

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
            $headers["authorization"] = "Bearer " . $this->pathao_token_data->token;
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
    public function Pathao_API_Response(bool $auth = false, string $api, string $method, ?array $data = [])
    {
        $response = ['data' => [], 'status' => Response::HTTP_OK];

        try {
            $httpClient = Http::timeout(100)->withHeaders($this->setHeaders($auth));
            $httpUrl = $this->base_url . $api;
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
