<?php

namespace Boom\Traits;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;

use Boom\Exceptions\ApiException;
use Boom\Facades\Controller;


/**
 * Emitter trait.
 */
trait Emitter {
    /**
     * Emit flags.
     *
     * @var array
     */
    protected $_flags = [ ];

    /**
     * Rooms to emit to.
     *
     * @var array
     */
    protected $_rooms = [ ];


    /**
     * Initialize properties for emitting.
     *
     * @return void
     */
    protected function _initEmitter() {
        $this->_nsp = '/';
        $this->_flags = array();
        $this->_rooms = array();
    }


    /**
     * Set emit flag.
     *
     * @param  string  $flag
     * @return null|$this
     */
    public function __get(string $flag) {
        if (//'compress' == $flag ||
            //'binary' == $flag ||
            'broadcast' == $flag ||
            'volatile' == $flag
        ) {
            $this->_flags[$flag] = true;
            return $this;
        }

        return null;
    }

    /**
     * Set compress flag.
     *
     * @param  bool  $compress
     * @return $this
     */
    public function compress(bool $compress = true) {
        $this->_flags['compress'] = $compress;
        return $this;
    }

    /**
     * Set binary flag.
     *
     * @param  bool  $binary
     * @return $this
     */
    public function binary(bool $binary = true) {
        $this->_flags['binary'] = $binary;
        return $this;
    }

    /**
     * Add destination room.
     *
     * @param  string  $room
     * @return $this
     */
    public function in(string $room) {
        if (!in_array($room, $this->_rooms)) {
            $this->_rooms[] = $room;
        }
        return $this;
    }

    /**
     * Add destination room.
     *
     * Synonym of `in`.
     *
     * @param  string  $room
     * @return $this
     */
    public function to(string $room) {
        return $this->in($room);
    }

    /**
     * Emit an event.
     *
     * @param  string  $event
     * @param  array  $args
     * @return mixed
     *
     * @throws \Boom\Exceptions\ApiException
     */
    public function emit(string $event, ...$args) {
        // Init namespace and source
        $nsp = '/';
        $source = null;

        // Prepare namespace and source
        if (\Boom\Socket::class == self::class) {
            $nsp = $this->nsp;
            $source = $this->id;
        } else if (\Boom\Nsp::class == self::class) {
            $nsp = $this->name;
            $source = null;
        }

        // Sends emit request
        $result = Controller::emit(
            $nsp,
            $source,
            $this->_flags,
            $this->_rooms,
            $event,
            ...$args
        );

        // Initialize emitter parameters
        $this->_initEmitter();

        // Return result from api
        return $result;
    }

    /**
     * Emit an `message` event.
     *
     * @param  array  $args
     * @return mixed
     */
    public function send(...$args) {
        return $this->emit('message', ...$args);
    }

    /**
     * Emit an `message` event.
     *
     * Synonym of `send`.
     *
     * @param  array  $args
     * @return mixed
     */
    public function write(...$args) {
        return $this->send(...$args);
    }
}
