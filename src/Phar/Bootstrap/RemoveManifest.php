<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Phar\Bootstrap;


use Illuminate\Contracts\Foundation\Application;
use Sebwite\Support\Filesystem;

class RemoveManifest
{

    public function bootstrap(Application $app)
    {
        $fs  = new Filesystem;
        if($fs->exists($app->getCachedServicesPath())){
            $fs->remove($app->getCachedServicesPath());
        }
        if($fs->exists($app->getCachedCompilePath())){
            $fs->remove($app->getCachedCompilePath());
        }
    }

}
