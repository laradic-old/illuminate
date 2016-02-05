<?php

namespace Laradic\Providers;

use Sebwite\Support\Path;
use Laradic\Support\Filesystem;
use Laradic\Support\ServiceProvider;

/**
 * This is the ConsoleServiceProvider.
 *
 * @author        Sebwite
 * @copyright     Copyright (c) 2015, Sebwite
 * @license       https://tldrlegal.com/license/mit-license MIT
 */
class ResourcesServiceProvider extends ServiceProvider
{
    /**
     * @var Filesystem
     */
    protected $fs;

    public function register()
    {
        $this->fs = Filesystem::create();
        $app      = parent::register();
        $this->registerViewPaths();
    }

    protected function registerViewPaths()
    {
        $view = $this->app->make('view');
        foreach ( $this->fs->directories(resources_path('views')) as $dir )
        {
            $ns = Path::getDirectoryName($dir);
            $view->addNamespace($ns, $dir);
        }
    }

}
