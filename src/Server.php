<?php

namespace Boom;

use Boom\Nsp;


/**
 * Equivalent of `Server` class from `socket.io`.
 */
class Server {
    /**
     * List of namespaces.
     *
     * @var array
     */
    public $nsps = [ ];


    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct() {
        // Create default namespace
        $this->of('/');
    }

    /**
     * Customized getter.
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get(string $name) {
        if ('sockets' == $name) {
            return $this->of('/');
        } else {
            return parent::_get($name);
        }
    }

    /**
     * Alias of $this->sockets.
     *
     * @return \Boom\Nsp
     */
    public function sockets() {
        return $this->sockets;
    }

    /**
     * Initializes and retrieves the given namespace by its pathname identifier `nsp`.
     *  If the namespace was already initialized it returns it immediately.
     *
     * @param  string  $nsp
     * @return \Boom\Nsp
     */
    public function of(string $nsp) {
        if ('/' !== $nsp[0]) {
            $nsp = "/$nsp";
        }

        if (empty($this->nsps[$nsp])) {
            $this->nsps[$nsp] = new Nsp($nsp);
        }

        return $this->nsps[$nsp];
    }

    /**
     * Shortcut to `in` method of default namespace.
     */
    public function in(...$args) {
        return $this->sockets->in(...$args);
    }

    /**
     * Shortcut to `to` method of default namespace.
     */
    public function to(...$args) {
        return $this->sockets->to(...$args);
    }

    /**
     * Shortcut to `emit` method of default namespace.
     */
    public function emit(...$args) {
        return $this->sockets->emit(...$args);
    }

    /**
     * Shortcut to `send` method of default namespace.
     */
    public function send(...$args) {
        return $this->sockets->send(...$args);
    }

    /**
     * Shortcut to `write` method of default namespace.
     */
    public function write(...$args) {
        return $this->sockets->write(...$args);
    }
}
