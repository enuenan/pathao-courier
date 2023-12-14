<?php


namespace Enan\PathaoCourier\DataDTO;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Enan\PathaoCourier\Requests\PathaoAccessTokenRequest;


class AccessTokenDTO
{
    /**
     * This will standardize the data that from a request
     * @param \Enan\PathaoCourier\Requests\PathaoAccessTokenRequest $request
     * @return array
     */
    public function fromRequest(PathaoAccessTokenRequest $request): array
    {
        return [
            "client_id" => $request->client_id,
            "client_secret" => $request->client_secret,
            "username" => $request->username,
            "password" => $request->password,
            "grant_type" => $request->grant_type,
        ];
    }

    /**
     * This will standardize the data that from a request
     * @param array $data
     * @return array
     */
    public function fromAccessTokenResponse(array $data): array
    {
        $secret_token = Str::random(20);
        $token = Arr::get($data, 'access_token');
        $refresh_token = Arr::get($data, 'refresh_token');
        $expires_in = time() + Arr::get($data, 'expires_in');

        return [
            "secret_token" => $secret_token,
            "token" => $token,
            "refresh_token" => $refresh_token,
            "expires_in" => $expires_in,
            "created_at" => now(),
            "updated_at" => now(),
        ];
    }

    /**
     * This will standardize the data that from a request
     * @param array $data
     * @return array
     */
    public function fromRefreshTokenResponse(array $data): array
    {
        $token = Arr::get($data, 'access_token');
        $refresh_token = Arr::get($data, 'refresh_token');
        $expires_in = time() + Arr::get($data, 'expires_in');

        return [
            "token" => $token,
            "refresh_token" => $refresh_token,
            "expires_in" => $expires_in,
            "updated_at" => now(),
        ];
    }
}
