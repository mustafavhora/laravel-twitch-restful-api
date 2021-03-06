<?php


namespace Skmetaly\TwitchApi\API;


/**
 * Class Video
 * API documentation : https://github.com/justintv/Twitch-API/blob/master/v3_resources/videos.md
 *
 * @package Skmetaly\TwitchApi\API
 */
class Videos extends BaseApi
{

    /**
     *
     * Returns a video object.
     *
     * @param $id
     *
     * @return mixed
     */
    public function video($id)
    {
        $response = $this->client->get('/kraken/videos/' . $id . '?api_version=5');
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Returns a list of videos created in a given time period sorted by number of views, most popular first.
     *
     * @param array $options
     *
     * @return mixed
     */
    public function videosTop($options = [])
    {
        $availableOptions = ['limit', 'offset', 'game', 'period'];
        $query            = [];
        //  Filter the available options
        foreach ($availableOptions as $option) {
            if (isset($options[ $option ])) {
                $query[ $option ] = $options[ $option ];
            }
        }
        $parameters          = $this->getDefaultHeaders();
        $parameters['query'] = $query;
        $response            = $this->client->get('/kraken/videos/top?api_version=5', $parameters);
        $response            = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * @param $channel
     *
     * @param $options
     *
     * @return json
     */
    public function channelsVideo($channel, $options = null)
    {
        $availableOptions = ['limit', 'offset', 'broadcasts', 'hls'];
        $query            = [];
        //  Filter the available options
        foreach ($availableOptions as $option) {
            if (isset($options[ $option ])) {
                $query[ $option ] = $options[ $option ];
            }
        }
        $parameters          = $this->getDefaultHeaders();
        $parameters['query'] = $query;
        $response            = $this->client->get('/kraken/channels/' . $channel . '/videos?api_version=5', $parameters);
        $response            = json_decode($response->getBody()->getContents(), true);
        return $response;
    }
}
