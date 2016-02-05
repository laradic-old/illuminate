<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Foundation\Providers;


use Illuminate\Database\SeedServiceProvider as ServiceProvider;
use Laradic\Foundation\Seeder;

class SeedServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('seeder', function ()
        {
            return new Seeder();
        });

        if ( config('app.debug') )
        {
            $this->registerSeedCommand();

            $this->commands('command.seed');
        }
    }

}
