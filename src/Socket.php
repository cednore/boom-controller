<?php

namespace Boom;

use Illuminate\Support\Arr;

use Boom\Traits\Emitter;
use Boom\Facades\Controller;


/**
 * Equivalent of `Socket` class from `socket.io`.
 */
class Socket {
    use Emitter;


    /**
     * Unique socket identifier.
     *
     * @var string
     */
    public $id = null;

    /**
     * Name of owner namespace.
     *
     * @var string
     */
    public $nsp = null;

    /**
     * List of rooms which this socket has been joined into.
     *
     * @var array
     */
    public $rooms = [ ];

    /**
     * Handshake details.
     *
     * @var array
     */
    public $handshake = [
        //
    ];

    /**
     * Decoded token object in case of the namespace of this socket uses JWT middleware.
     *
     * @var array
     */
    public $decoded_token = [
        //
    ];


    /**
     * Constructor.
     *
     * @param  string  $id
     * @param  string  $nsp
     * @param  array  $rooms
     * @param  array  $handshake
     * @param  array  $decoded_token
     * @return void
     */
    public function __construct(
        string $id = null,
        string $nsp = null,
        array $rooms = [],
        array $handshake = [],
        array $decoded_token = []
    ) {
        $this->setSocket($id, $nsp, $rooms, $handshake, $decoded_token);
    }


    /**
     * Set socket data from arguments.
     *
     * @param  string  $id
     * @param  string  $nsp
     * @param  array  $rooms
     * @param  array  $handshake
     * @param  array  $decoded_token
     * @return void
     */
    public function setSocket(
        string $id = null,
        string $nsp = null,
        array $rooms = [],
        array $handshake = [],
        array $decoded_token = []
    ) {
        $this->id = $id;
        $this->nsp = $nsp;
        $this->rooms = $rooms;
        $this->handshake = $handshake;
        $this->decoded_token = $decoded_token;
    }

    /**
     * Join this socket into a room or several rooms.
     *
     * @param  string|array  $room
     * @return mixed
     */
    public function join($room) {
        return Controller::join($this->nsp, $this->id, Arr::wrap($room));
    }

    /**
     * Let this socket leave from a room.
     *
     * @param  string  $room
     * @return mixed
     */
    public function leave($room) {
        return Controller::leave($this->nsp, $this->id, $room);
    }
}
