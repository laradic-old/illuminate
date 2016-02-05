<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Console;

use Sebwite\Support\Console\Color;

/**
 * This is the class Command.
 *
 * @package        Laradic
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 *
 * @property \Laradic\Foundation\Application $laravel
 * @method \Laradic\Foundation\Application getLaravel()
 */
abstract class Command extends \Sebwite\Support\Console\Command
{

    protected $debug = false;


    protected function fs()
    {
        return app('fs');
    }

    protected function style($styles, $str)
    {
        return with(new Color())->apply($styles, $str);
    }

    public function __construct()
    {
        if ( $this->debug === true && (bool) config('app.debug') !== true)
        {
            $this->enabled = false;
        }
        parent::__construct();
    }

    public function getProcessedHelp()
    {
        $name = parent::getName();

        $replace = [
            '%command.name%'      => $name,
            '%command.full_name%' => $_SERVER[ 'PHP_SELF' ] . ' ' . $name,
            '%command.bin%'       => $this->getLaravel()->getSlug() . ' ' . $name
        ];

        return str_replace(array_keys($replace), array_values($replace), $this->getHelp() ?: $this->getDescription());
    }

    /**
     * @return boolean
     */
    public function isDebug()
    {
        return $this->debug;
    }


}
