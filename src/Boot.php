<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic;

use Closure;
use Illuminate\Contracts as C;
use Sebwite\Support\Path;
use Laradic\Foundation as F;

class Boot
{
    protected static $consoleKernel = Console\Kernel::class;

    protected static $httpKernel = F\Http\Kernel::class;

    protected static $exceptionHandler = F\Exceptions\Handler::class;

    protected static $app = F\Application::class;

    protected static $booted = false;

    protected static $bootingCallbacks = [];

    protected static $bootedCallbacks = [];

    protected static function checkImplements($called, $class, $interface)
    {
        if ( !in_array($interface, class_implements($class), true) )
        {
            throw new \InvalidArgumentException("The given Boot::{$called}({$class}) class needs to implement '{$interface}'");
        }
    }

    public static function console($kernel)
    {
        static::checkImplements('console', $kernel, C\Console\Kernel::class);
        static::$consoleKernel = $kernel;
    }

    public static function http($kernel)
    {
        static::checkImplements('http', $kernel, C\Http\Kernel::class);
        static::$httpKernel = $kernel;
    }

    public static function exceptions($handler)
    {
        static::checkImplements('exception', $handler, C\Debug\ExceptionHandler::class);
        static::$exceptionHandler = $handler;
    }

    public static function app($app)
    {
        static::checkImplements('app', $app, C\Foundation\Application::class);
        static::$app = $app;
    }

    public static function bootAsMaster($appPath = null, $basePath = null, $name = null, $version = null)
    {
        $app = static::boot($appPath, $basePath, $name, $version);

        $app->useDatabasePath(Path::join(__DIR__, '..', 'database'));

        $app->singleton(C\Console\Kernel::class, static::$consoleKernel);

        $app->singleton(C\Http\Kernel::class, static::$httpKernel);

        $app->singleton(C\Debug\ExceptionHandler::class, static::$exceptionHandler);

        $kernel = $app->make(C\Console\Kernel::class);

        foreach(static::$bootingCallbacks as $callback)
        {
            $app->call($callback, [ 'kernel' => $kernel ]);
        }

        $status = $kernel->handle(
            $input = new \Symfony\Component\Console\Input\ArgvInput,
            new \Symfony\Component\Console\Output\ConsoleOutput
        );

        foreach(static::$bootedCallbacks as $callback)
        {
            $app->call($callback, [ 'kernel' => $kernel ]);
        }

        $kernel->terminate($input, $status);

        exit($status);
    }

    public static function bootAsSlave(C\Foundation\Application $app)
    {
      #  $app->register(Providers\SlaveServiceProvider::class);
    }

    public static function booting(Closure $callback)
    {
        return array_push(static::$bootingCallbacks, $callback);
    }

    public static function booted(Closure $callback)
    {
        return array_push(static::$bootedCallbacks, $callback);
    }

    /**
     * boot method
     *
     * @param null|string $appPath
     * @param null|string $basePath
     * @param null|string $name
     * @param null|string $version
     *
     * @return F\Application
     */
    protected static function boot($appPath = null, $basePath = null, $name = null, $version = null)
    {
        $appPath  = $appPath === null ? realpath(__DIR__ . '/../app') : $appPath;
        $basePath = $basePath === null ? realpath(__DIR__ . '/../') : $basePath;
        $name     = $name === null ? static::getDefaultName() : $name;
        $version  = $version === null ? static::getDefaultVersion() : $version;

        return new static::$app($name, $version, $appPath, $basePath);
    }

    protected static function getDefaultName()
    {
        return trim(file_get_contents(realpath(__DIR__ . '/NAME')));
    }

    protected static function getDefaultVersion()
    {
        return trim(file_get_contents(realpath(__DIR__ . '/VERSION')));
    }

}
