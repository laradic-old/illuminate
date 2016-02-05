<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Providers;


use Laradic\Generators\GeneratorsServiceProvider;
use Laradic\Idea\IdeaServiceProvider;
use Laradic\Projects\ProjectsServiceProvider;
use Laradic\System\SystemServiceProvider;
use Laradic\Support\ServiceProvider;

class SlaveServiceProvider extends ServiceProvider
{
    protected $providers = [
        GeneratorsServiceProvider::class,
        ProjectsServiceProvider::class,
        SystemServiceProvider::class,
        IdeaServiceProvider::class,

    ];
}
