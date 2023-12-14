<?php


namespace Enan\PathaoCourier\APIBase;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Enan\PathaoCourier\Services\DataServiceOutput;
use Enan\PathaoCourier\APIBase\PathaoBaseAPI;
use Enan\PathaoCourier\DataDTO\AccessTokenDTO;
use Illuminate\Http\Request;
use Enan\PathaoCourier\Services\PathaoHelperFunction;

class PathaoAuth extends PathaoBaseAPI
{
    public $secret_token;
    public $table_name;
    public $pathao_token_data;

    public function __construct()
    {
        $this->secret_token = PathaoHelperFunction::getSecretToken();
        $this->table_name = PathaoHelperFunction::getTableName();

        $this->pathao_token_data = PathaoHelperFunction::getPathaoTokenData();

        if ($this->pathao_token_data) {
            $checkAccessTokenIsValid = $this->checkAccessTokenIsValid();
            // If access token is not valid request for a new token.
            if (!$checkAccessTokenIsValid) {
                $this->getNewAccesstoken();
            }
        }
    }

    /**
     * Issue a token from Pathao Courier
     * @param array $cred
     * @return \Enan\PathaoCourier\Services\DataServiceOutput
     */
    public function getAccessToken(array $cred): DataServiceOutput
    {
        $url = "aladdin/api/v1/issue-token";

        $API_response = $this->Pathao_API_Response(false, $url, Request::METHOD_POST, $cred);

        $data = Arr::get($API_response, 'data') ?: [];
        $message = Arr::get($API_response, 'message') ?: null;
        $is_success = $this->isSuccessfulResponse(Arr::get($API_response, 'status'));
        $status_code = Arr::get($API_response, 'data.code') ?: [];

        if ($is_success) {
            $type = Arr::get($cred, 'grant_type');

            if ($type == config('pathao-courier.pathao_grant_type_password')) {
                $response = (new AccessTokenDTO)->fromAccessTokenResponse($data);

                if ($this->pathao_token_data) {
                    $updated = DB::table($this->table_name)
                        ->where('secret_token', '=', $this->pathao_token_data->secret_token)
                        ->update($response);
                } else {
                    $save = DB::table($this->table_name)->insert($response);
                }

                $message = 'Token stored successfully';
                $data['secret_token'] = Arr::get($response, 'secret_token');
            } else {
                $response = (new AccessTokenDTO)->fromRefreshTokenResponse($data);

                $updated = DB::table($this->table_name)
                    ->where('secret_token', '=', $this->pathao_token_data->secret_token)
                    ->update($response);
                $message = 'Token updated successfully';
            }
        }

        return new DataServiceOutput($data, $message, $is_success, $status_code);
    }

    /**
     * This function will check the current token is valid or not
     * @return bool
     */
    private function checkAccessTokenIsValid(): bool
    {
        return $this->pathao_token_data->expires_in >= time();
    }

    /**
     * This function will return the remaining days of expiration
     * it will return both days left and the expected date.
     * @return \Enan\PathaoCourier\Services\DataServiceOutput
     */
    public function getAccessTokenExpiryDaysLeft(): DataServiceOutput
    {
        $days_left = ceil(($this->pathao_token_data->expires_in - time()) / 86400);
        $expected_date = now()->addDays($days_left)->toDateString();

        $response = [
            'days_left' => $days_left,
            'expected_expiration_date' => $expected_date
        ];
        $message = $days_left . " days left for Token expiration";
        return new DataServiceOutput($response, $message);
    }

    /**
     * Get new access token if the token is outdated.
     * @return \Enan\PathaoCourier\Services\DataServiceOutput
     */
    public function getNewAccesstoken(): DataServiceOutput
    {
        $cred = [
            "client_id" => config('pathao-courier.pathao_client_id'),
            "client_secret" => config('pathao-courier.pathao_client_secret'),
            "refresh_token" => $this->pathao_token_data->refresh_token,
            "grant_type" => config('pathao-courier.pathao_grant_type_refresh_token'),
        ];

        return $this->getAccessToken($cred);
    }
}
