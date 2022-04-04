<?php

namespace Boom;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;

use Boom\Exceptions\ApiException;


/**
 * Controller class.
 */
class Controller {
    /**
     * Http client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected static $client;


    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct() {
        // Initialize http client
        self::$client = new HttpClient([
            'headers' => [
                'Authorization' => 'Bearer '.config('boom.api.auth.token'),
            ],
            'base_uri' => config('boom.api.base_url')
        ]);
    }


    /**
     * Sends an emit request to boom-server.
     *
     * @param  string  $nsp
     * @param  string  $source
     * @param  array  $flags
     * @param  array  $rooms
     * @param  string  $event
     * @param  array  $args
     * @return mixed
     *
     * @throws \Boom\Exceptions\ApiException
     */
    public static function emit(
        string $nsp,
        string $source = null,
        array $flags,
        array $rooms,
        string $event,
        ...$args
    ) {
        try {
            return json_decode(self::$client->post('/emit', [RequestOptions::JSON => [
                'nsp' => $nsp,
                'source' => $source,
                'flags' => $flags,
                'rooms' => $rooms,
                'event' => $event,
                'args' => $args,
            ]])->getBody(), true);
        } catch (Exception $e) {
            // TODO:
            throw new ApiException;
        }
    }

    /**
     * Sends a join request to boom-server.
     *
     * @param  string  $nsp
     * @param  string  $sid
     * @param  array  $rooms
     * @return mixed
     *
     * @throws \Boom\Exceptions\ApiException
     */
    public static function join(string $nsp, string $sid, array $rooms) {
        try {
            return json_decode(self::$client->post('/join', [RequestOptions::JSON => [
                'nsp' => $nsp,
                'socket' => $sid,
                'rooms' => $rooms,
            ]])->getBody(), true);
        } catch (Exception $e) {
            // TODO:
            throw new ApiException;
        }
    }

    /**
     * Sends a leave request to boom-server.
     *
     * @param  string  $nsp
     * @param  string  $sid
     * @param  string  $room
     * @return mixed
     *
     * @throws \Boom\Exceptions\ApiException
     */
    public static function leave(string $nsp, string $sid, string $room) {
        try {
            return json_decode(self::$client->post('/leave', [RequestOptions::JSON => [
                'nsp' => $nsp,
                'socket' => $sid,
                'room' => $room,
            ]])->getBody(), true);
        } catch (Exception $e) {
            // TODO:
            throw new ApiException;
        }
    }
}
