<?php

namespace Laradic\Foundation\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Sebwite\Support\Filesystem;

class EnsureDatabaseFile
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $path = config('database.connections.sqlite.database');
        $fs   = new Filesystem;
        if ( !$fs->exists($path) )
        {
            $fs->touch($path);
        }
    }
}
