<?php

namespace Boom;

use Illuminate\Support\Facades\DB;

use Boom\Traits\Emitter;
use Boom\Socket;


/**
 * Equivalent of `Namespace` class from `socket.io`.
 */
class Nsp {
    use Emitter;


    /**
     * Name of this namespace with '/' character.
     *
     * e.g; '/', '/namespace123', '/nsp'
     *
     * @var string
     */
    public $name = null;

    /**
     * List of sockets connected to this namespace.
     *
     * @var array
     */
    public $sockets = [ ];


    /**
     * Constructor.
     *
     * @param  string  $name
     * @return void
     */
    public function __construct(string $name) {
        // Set name
        $this->setName($name);

        // Fetch sockets
        $this->fetchSockets();
    }


    /**
     * Set name of this namespace.
     *
     * @param  string  $name
     * @return void
     */
    protected function setName(string $name) {
        if ('/' !== $name[0]) {
            $name = "/$name";
        }
        $this->name = $name;
    }

    /**
     * Fetch socket records from and create Socket instances.
     */
    protected function fetchSockets() {
        // Prepare initial query
        $query = DB::connection(config('boom.db.connection'))
            ->table(config('boom.db.tables.sockets'))
            ->select();

        // Filter matching records
        if ('/' == $this->name) {
            $query = $query->where('id', 'NOT LIKE', "/%");
        } else {
            $query = $query->where('id', 'LIKE', "$this->name#%");
        }

        // Iterate records and make Socket instances
        foreach ($query->cursor() as $socket) {
            $data = json_decode($socket->data, true);
            $this->sockets[$socket->id] = new Socket(
                $socket->id,
                $this->name,
                $data['rooms'],
                $data['handshake'],
                array_key_exists('decoded_token', $data) ? $data['decoded_token'] : [ ]
            );
        }
    }
}
