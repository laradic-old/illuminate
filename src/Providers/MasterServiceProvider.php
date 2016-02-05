<?php

namespace Laradic\Providers;

use Sebwite\Support\Str;
use Laradic\Support\ServiceProvider;

/**
 * This is the ConsoleServiceProvider.
 *
 * @author        Sebwite
 * @copyright     Copyright (c) 2015, Sebwite
 * @license       https://tldrlegal.com/license/mit-license MIT
 */
class MasterServiceProvider extends ServiceProvider
{

    public function register()
    {
        $app = parent::register();

        $exists = $app->make('db.connection')->getSchemaBuilder()->hasTable('migrations');
        if ( config('swcli.first_run') || !$exists )
        {
            $migrator = $app->make('migrator');
            if ( !$migrator->repositoryExists() )
            {
                $migrator->getRepository()->createRepository();
            }
            $migrator->run(database_path('migrations'));
        }
    }

    /**
     * Generate a random key for the application.
     *
     * @param  string $cipher
     *
     * @return string
     */
    protected function getRandomKey($cipher)
    {

        if ( $cipher === 'AES-128-CBC' )
        {
            return Str::random(16);
        }

        return Str::random(32);
    }
}
