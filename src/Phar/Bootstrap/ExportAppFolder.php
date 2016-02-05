<?php

namespace Laradic\Phar\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Sebwite\Support\Filesystem;

class ExportAppFolder
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
        $fs = new Filesystem;
        $fs->copyDirectory(app_path(), export_path());
    }


}
