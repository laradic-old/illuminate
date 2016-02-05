<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Phar\Bootstrap;


class SetPath
{
    public function bootstrap($app)
    {
        $app->setAppPath($app->exportPath());
    }
}