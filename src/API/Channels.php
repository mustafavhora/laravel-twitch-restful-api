<?php


namespace Skmetaly\TwitchApi\API;

use GuzzleHttp\Client;


/**
 * Class Authentication
 * API Documentation : https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md
 *
 * @package Skmetaly\TwitchApi\API
 */
class Channels extends BaseApi
{

    /**
     * Returns a channel object.
     *
     * @param $channel
     *
     * @return mixed
     */
    public function channel($channel)
    {
        $response = $this->client->get(config('twitch-api.api_url') . '/kraken/channels/' . $channel . '?api_version=5');
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Returns a channel object of authenticated user. Channel object includes stream key.
     *
     * Authenticated, required scope: channel_read
     *
     * @param null $token
     *
     * @return mixed
     * @throws \Skmetaly\TwitchApi\Exceptions\RequestRequiresAuthenticationException
     */
    public function authenticatedChannel($token = null)
    {
        $token    = $this->getToken();
        $request  = $this->createRequest('GET', config('twitch-api.api_url') . '/kraken/channel?api_version=5', $token);
        $response = $this->client->send($request);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Update channel's status or game.
     * Authenticated, required scope: channel_editor
     *
     * Name    Required?    Type    Description
     * status    optional    string    Channel's title.
     * game    optional    string    Game category to be classified as.
     * delay    optional    string    Channel delay in seconds. Requires the channel owner's OAuth token.
     *
     * @param      $channel
     * @param      $options
     * @param null $token
     *
     * @return json
     * @throws ClientException
     */
    public function putChannel($channel, $options, $token = null)
    {
        $token            = $this->getToken($token);
        $url              = config('twitch-api.api_url') . '/kraken/channels/' . $channel . '?api_version=5';
        $availableOptions = ['status', 'game', 'delay'];
        //  Filter the available options
        foreach ($availableOptions as $option) {

            if (isset($options[ $option ])) {

                $channelOptions[ $option ] = $options[ $option ];
            }
        }
        //  Get the default headers that are for all requests
        $params = $this->getDefaultHeaders($token);
        //  We send data through json
        $params['headers']['Content-type'] = ['application/json'];
        //  Data
        $params['json'] = ['channel' => $channelOptions];
        $client         = new Client();
        $request        = $client->createRequest('PUT', $url, $params);
        $response       = $client->send($request);
        $response       = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Resets channel's stream key.
     * Authenticated, required scope: channel_stream
     *
     * @param      $channel
     * @param null $token
     *
     * @return json
     */
    public function deleteStreamKey($channel, $token = null)
    {
        $token    = $this->getToken($token);
        $url      = config('twitch-api.api_url') . '/kraken/channels/' . $channel . '/stream_key?api_version=5';
        $request  = $this->createRequest('DELETE', $url, $token);
        $response = $this->client->send($request);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Start commercial on channel.
     * Authenticated, required scope: channel_commercial
     *
     * @param      $channel
     * @param int $length
     * @param null $token
     */
    public function postCommercial($channel, $length = 30, $token = null)
    {
        $token           = $this->getToken($token);
        $url             = config('twitch-api.api_url') . '/channels/' . $channel . '/commercial';
        $options         = $this->getDefaultHeaders($token);
        $options['body'] = ['length' => $length];
        $request         = $this->client->createRequest('POST', $url, $options);
        $response        = $this->client->send($request);
        $response        = json_decode($response->getBody()->getContents(), true);
        return $response;
    }
}
