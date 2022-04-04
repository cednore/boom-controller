<?php

namespace Boom\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * Boom Facade.
 */
class Boom extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return self::class;
    }
}
