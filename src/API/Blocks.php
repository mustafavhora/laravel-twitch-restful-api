<?php

namespace Skmetaly\TwitchApi\API;


/**
 * Class Blocks
 * API Documentation : https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md
 *
 * @package Skmetaly\TwitchApi\API
 */
class Blocks extends BaseApi
{

    /**
     * Returns a list of blocks objects on :login's block list. List sorted by recency, newest first.
     * Authenticated, required scope: user_blocks_read
     *
     * @param      $login
     *
     * @param null $token
     *
     * @return json
     */
    public function blocks($login, $token = null)
    {
        $token    = $this->getToken($token);
        $url      = config('twitch-api.api_url') . '/kraken/users/' . $login . '/blocks?api_version=5';
        $request  = $this->createRequest('GET', $url, $token);
        $response = $this->client->send($request);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Adds :target to :user's block list. :user is the authenticated user and :target is user to be blocked. Returns a blocks object.
     * Authenticated, required scope: user_blocks_edit
     *
     * @param      $user
     * @param      $target
     * @param null $token
     *
     * @return json
     */
    public function putBlock($user, $target, $token = null)
    {
        $token    = $this->getToken($token);
        $url      = 'https://api.twitch.tv/kraken/users/' . $user . '/blocks/' . $target . '?api_version=5';
        $type     = 'PUT';
        $request  = $this->createRequest($type, $url, $token);
        $response = $this->client->send($request);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Removes :target from :user's block list. :user is the authenticated user and :target is user to be unblocked.
     * Authenticated, required scope: user_blocks_edit
     *
     * @param      $user
     * @param      $target
     * @param null $token
     *
     * @return mixed
     */
    public function deleteBlock($user, $target, $token = null)
    {
        $token = $this->getToken($token);

        $url = 'https://api.twitch.tv/kraken/users/' . $user . '/blocks/' . $target . '?api_version=5';

        $type = 'DELETE';

        $request = $this->createRequest($type, $url, $token);

        $response = $this->client->send($request);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }
}
