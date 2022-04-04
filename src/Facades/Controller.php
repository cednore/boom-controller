<?php

namespace Boom\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * Controller Facade.
 *
 * @property static \GuzzleHttp\Client  $client
 * @method static mixed emit(string $nsp, string $source, array $flags, array $rooms, string $event, ...$args) Sends an emit request to boom-server
 * @method static mixed join(string $nsp, string $sid, array $rooms) Sends a join request to boom-server
 * @method static mixed leave(string $nsp, string $sid, string $room) Sends a leave request to boom-server
 */
class Controller extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return self::class;
    }
}
