<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Phar\Bootstrap;


use Illuminate\Contracts\Foundation\Application;
use Sebwite\Support\Filesystem;

class EnsureDirectories
{
    protected $app;

    /**
     * @var Filesystem
     */
    protected $fs;

    public function bootstrap(Application $app)
    {
        $this->app = $app;
        $this->fs  = new Filesystem;
        $paths     = [ $app->exportPath(), $app->homePath(), $app->storagePath(), $app->databasePath(), $app->publicPath(), $app->configPath() ];
        foreach ( $paths as $path )
        {
            $this->ensureDirectory($path);
        }
        $storagePaths = [ 'app', 'framework', 'framework/cache', 'framework/views', 'framework/sessions', 'logs', $app->getSlug() ];
        foreach ( $storagePaths as $path )
        {
            $this->ensureDirectory(path_join($app->storagePath(), $path));
        }
    }

    protected function ensureDirectory($path)
    {
        if ( !$this->fs->exists($path) )
        {
            $this->fs->makeDirectory($path, 0755, true);
        }
    }
}
