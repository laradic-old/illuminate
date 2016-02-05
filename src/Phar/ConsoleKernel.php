<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Phar;


use Laradic\Console\Kernel;
use Laradic\Foundation\Bootstrap as FB;

class ConsoleKernel extends Kernel
{

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        FB\DetectEnvironment::class,
        #FB\BootFilesystem::class,

        # Prepare to local user files
        Bootstrap\SetPath::class,
        Bootstrap\RemoveManifest::class,
        Bootstrap\EnsureDirectories::class,
        Bootstrap\ExportAppFolder::class,

        FB\LoadConfig::class,
        Bootstrap\EnsureDatabaseFile::class,

        FB\ConfigureLogging::class,
        FB\HandleExceptions::class,
        FB\RegisterFacades::class,
        FB\SetRequestForConsole::class,
        FB\RegisterProviders::class,
        FB\BootProviders::class,
    ];

}