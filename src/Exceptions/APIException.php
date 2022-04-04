<?php

namespace Boom\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Exception being thrown while interacting with boom-server.
 */
class ApiException extends Exception {
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report() {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request) {
        return response([
            // TODO:
        ], Response::HTTP_FORBIDDEN);
    }
}
