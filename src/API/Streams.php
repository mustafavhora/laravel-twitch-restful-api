<?php


namespace Skmetaly\TwitchApi\API;


/**
 * Class Streams
 * https://github.com/justintv/Twitch-API/blob/master/v3_resources/streams.md
 *
 * @package Skmetaly\TwitchApi\API
 */
class Streams extends BaseApi
{

    /**
     * Returns a stream object if live.
     *
     * @param $channel
     *
     * @return json
     */
    public function streamsChannel($channel)
    {
        $response = $this->client->get(config('twitch-api.api_url') . '/kraken/streams/' . $channel . '?api_version=5');
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Returns a list of stream objects that are queried by a number of parameters sorted by number of viewers descending.
     *
     * @param $options
     *
     * @return mixed
     */
    public function streams($options)
    {
        $availableOptions = ['game', 'channel', 'limit', 'offset', 'client_id'];

        $parameters = [];

        //  Filter the available options
        foreach ($availableOptions as $option) {

            if (isset($options[ $option ])) {

                $parameters[ $option ] = $options[ $option ];
            }
        }
        $response = $this->client->get('/kraken/streams/?api_version=5', ['query' => $parameters]);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Returns a list of featured (promoted) stream objects.
     *
     * @param array $options
     *
     * @return mixed
     */
    public function streamsFeatured($options = [])
    {
        $availableOptions = ['limit', 'offset'];

        $parameters = [];

        //  Filter the available options
        foreach ($availableOptions as $option) {

            if (isset($options[ $option ])) {

                $parameters[ $option ] = $options[ $option ];
            }
        }
        $response = $this->client->get('/kraken/streams/featured?api_version=5', ['query' => $parameters]);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }

    /**
     * Returns a summary of current streams.
     *
     * @param $options
     *
     * @return mixed
     */
    public function streamsSummary($options = [])
    {
        $availableOptions = ['game', 'limit', 'offset'];

        $parameters = [];

        //  Filter the available options
        foreach ($availableOptions as $option) {

            if (isset($options[ $option ])) {

                $parameters[ $option ] = $options[ $option ];
            }
        }
        $response = $this->client->get('/kraken/streams/summary?api_version=5', ['query' => $parameters]);
        $response = json_decode($response->getBody()->getContents(), true);
        return $response;
    }
}
