<?php


namespace Skmetaly\TwitchApi\API;

use GuzzleHttp\Client;


/**
 * Class Authentication
 * API Documentation : https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md
 *
 * @package Skmetaly\TwitchApi\API
 */
class Chat extends BaseApi
{

    /**
     * Returns a list of all emoticon objects for Twitch.
     *
     * @param $channel
     *
     * @return json
     */
    public function chatChannel($channel)
    {
        $response = $this->client->get('kraken/chat/' . $channel . '?api_version=5');
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Returns a list of chat badges that can be used in the :channel's chat.
     *
     * @param $channel
     *
     * @return mixed
     */
    public function chatBadges($channel)
    {
        $response = $this->client->get('kraken/chat/' . $channel . '/badges?api_version=5');
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Returns a list of all emoticon objects for Twitch.
     *
     * @return mixed
     */
    public function chatEmoticons()
    {
        $response = $this->client->get('/kraken/chat/emoticons?api_version=5');
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }
}
