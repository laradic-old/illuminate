<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Cli extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'swcli';
    }
}
