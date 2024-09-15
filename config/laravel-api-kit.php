<?php

/**
 * Package Configuration File
 * 
 * This configuration file is used by the LaravelAPIKit package to define
 * settings and options for the package. The configuration values are
 * loaded from the environment file and are used to customize the package's
 * behavior.
 *
 * @package Haxneeraj\LaravelAPIKit
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Dev Debug Mode
    |--------------------------------------------------------------------------
    |
    | This option determines whether the package is in development debug mode.
    | When enabled, detailed error messages and debugging information will
    | be displayed. This is useful for development but should be disabled
    | in production to avoid exposing sensitive information.
    |
    | Set this to true to enable dev debug mode, or false to disable it.
    | The value is retrieved from the environment file (.env) with a default
    | value of false.
    |
    */
    'dev_mode' => env('HAX_DEBUG_MODE', false),
];
