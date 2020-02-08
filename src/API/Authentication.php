<?php


namespace Skmetaly\TwitchApi\API;

use GuzzleHttp\Client;


/**
 * Class Authentication
 * API Documentation : https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md
 *
 * @package Skmetaly\TwitchApi\API
 */
class Authentication extends BaseApi
{

    /**
     * Returns the authentication URL where the user needs to be redirected to
     * @return string
     */
    public function authenticationURL()
    {
        $clientId = config('twitch-api.client_id');
        $scopes = implode('+', config('twitch-api.scopes'));
        $redirectURL = config('twitch-api.redirect_url');

        return config('twitch-api.api_url') . '/kraken/oauth2/authorize?api_version=5&response_type=code&client_id=' . $clientId . '&redirect_uri=' . $redirectURL . '&scope=' . $scopes;
    }

    /**
     * Requests a token for a given code
     *
     * @param $code
     *
     * @return mixed
     * @throws \Exception
     */
    public function requestToken($code)
    {
        $parameters = [
            'client_id' => config('twitch-api.client_id'),
            'client_secret' => config('twitch-api.client_secret'),
            'redirect_uri' => config('twitch-api.redirect_url'),
            'code' => $code,
            'grant_type' => 'authorization_code'
        ];

        try {
            $client = new Client();

            $response = $client->post(config('twitch-api.api_url') . '/kraken/oauth2/token?api_version=5', ['body' => $parameters]);
            $response = json_decode($response->getBody()->getContents(), true);
            if (isset($response[ 'access_token' ])) {

                return $response[ 'access_token' ];
            }

        } catch (\Exception $e) {

            throw $e;
        }
    }
}
