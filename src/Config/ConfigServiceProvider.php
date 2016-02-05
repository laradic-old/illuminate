<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Config;


use PDOException;
use Laradic\Config\DatabaseRepository;
use Sebwite\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    protected $commands = [
        Commands\ConfigCommand::class
    ];

    protected $providers = [
       # \Illuminate\Database\DatabaseServiceProvider::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = parent::register();

        if($app->bound('db')) {
            $this->overrideConfigInstance();

            $this->setUpConfig();
        }
    }

    /**
     * Overrides the config instance.
     *
     * @return void
     */
    protected function overrideConfigInstance()
    {
        $this->app->register(\Illuminate\Cache\CacheServiceProvider::class);

        $repository = new DatabaseRepository([ ], $this->app[ 'cache' ]);

        $oldItems = $this->app[ 'config' ]->all();

        foreach ( $oldItems as $key => $value )
        {
            $repository->set($key, $value);
        }

        $this->app->instance('config', $repository);
    }


    /**
     * Sets up, fetches and caches configurations.
     *
     * @return void
     */
    protected function setUpConfig()
    {
        $config = $this->app[ 'config' ];

        $table = $this->app[ 'config' ][ 'composite-config.table' ];

        try
        {
            $config->setDatabase($this->app[ 'db' ]->connection());
            $config->setDatabaseTable($table);
            $config->fetchAndCache();
        }
        catch (PDOException $e)
        {
        }
    }
}
