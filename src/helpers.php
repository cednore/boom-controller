<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;


if (! function_exists('laravel_project_root_namespace')) {
    /**
     * Get root namespace name of current laravel project.
     *
     * @return string|null
     */
    function laravel_project_root_namespace() {
        $meta_path = base_path('composer.json');

        if (file_exists($meta_path)) {
            $meta = json_decode(app('files')->get($meta_path), true);
            $psr4 = Arr::get($meta, 'autoload.psr-4');
            if (is_array($psr4)) {
                return Str::finish(array_keys($psr4)[0], '\\');
            }
        }

        return null;
    }
}

if (! function_exists('safe_ioeventname')) {
    /**
     * Get URL-friendly safe socket.io event name.
     *
     * @param  string  $event
     * @return string
     */
    function safe_ioeventname(string $event) {
        return Str::slug($event);
    }
}

if (! function_exists('ioevn')) {
    /**
     * Get URL-friendly safe socket.io event name.
     *
     * Synonym of `safe_ioeventname`.
     *
     * @param  string  $event
     * @return string
     */
    function ioevn(string $event) {
        return safe_ioeventname($event);
    }
}

if (! function_exists('safe_ionspname')) {
    /**
     * Get URL-friendly safe socket.io namespace name.
     *
     * @param  string  $nsp
     * @return string
     */
    function safe_ionspname(string $nsp) {
        return Str::slug($nsp);
    }
}

if (! function_exists('ionsp')) {
    /**
     * Get URL-friendly safe socket.io namespace name.
     *
     * Synonym of `safe_ionspname`.
     *
     * @param  string  $nsp
     * @return string
     */
    function ionsp(string $nsp) {
        return safe_ionspname($nsp);
    }
}
