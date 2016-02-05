<?php

namespace Laradic\Foundation\Bootstrap;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Sebwite\Support\Filesystem;
use Sebwite\Support\Path;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class LoadConfig
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
        $config = new Repository();

        $app->instance('config', $config);
        $this->loadConfigurationFiles($app, $config);
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @param  \Illuminate\Contracts\Config\Repository      $repository
     *
     * @return void
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        foreach ( $this->getConfigurationFiles($app) as $key => $path ) {
            $repository->set($key, require $path);
        }
    }

    protected function copyDefaultConfigurationFiles(Application $app)
    {
        $fs    = new Filesystem;
        $files = Finder::create()->files()->name('*.php')->in(Path::join(__DIR__, '..', '..', 'app', 'config'))->files();
        foreach ( $files as $file ) {
            $dest = Path::join($app->configPath(), $file->getRelativePathname());
            $fs->copy($file->getPathname(), $dest);
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     *
     * @return array
     */
    protected function getConfigurationFiles(Application $app)
    {
        $files = [ ];

        $configPath = realpath($app->configPath());

        foreach ( Finder::create()->files()->name('*.php')->in($configPath) as $file ) {
            $nesting = $this->getConfigurationNesting($file, $configPath);

            $files[ $nesting . basename($file->getRealPath(), '.php') ] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param  \Symfony\Component\Finder\SplFileInfo $file
     * @param  string                                $configPath
     *
     * @return string
     */
    protected function getConfigurationNesting(SplFileInfo $file, $configPath)
    {
        $directory = dirname($file->getRealPath());

        if ( $tree = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR) ) {
            $tree = str_replace(DIRECTORY_SEPARATOR, '.', $tree) . '.';
        }

        return $tree;
    }
}
