<?php

namespace Laradic\Foundation\Providers;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Routing\Redirector;
use Laradic\Foundation\Http\FormRequest;
use Sebwite\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class FoundationServiceProvider extends ServiceProvider
{
    protected $providers = [

        ComposerServiceProvider::class,
        #MigrationServiceProvider::class,
        #SeedServiceProvider::class,
        #FilesystemServiceProvider::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Initialize the form request with data from the given request.
     *
     * @param  \Laradic\Foundation\Http\FormRequest     $form
     * @param  \Symfony\Component\HttpFoundation\Request $current
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->configureFormRequests();
    }

    /**
     * Configure the form request related services.
     *
     * @return void
     */
    protected function configureFormRequests()
    {
        $this->app->afterResolving(function (ValidatesWhenResolved $resolved)
        {
            $resolved->validate();
        });

        $this->app[ 'events' ]->listen(RouteMatched::class, function ()
        {
            $this->app->resolving(function (FormRequest $request, $app)
            {
                $this->initializeRequest($request, $app[ 'request' ]);

                $request->setContainer($app)->setRedirector($app->make(Redirector::class));
            });
        });
    }

    /**
     * Initialize the form request with data from the given request.
     *
     * @param  \Laradic\Foundation\Http\FormRequest     $form
     * @param  \Symfony\Component\HttpFoundation\Request $current
     *
     * @return void
     */
    protected function initializeRequest(FormRequest $form, Request $current)
    {
        $files = $current->files->all();

        $files = is_array($files) ? array_filter($files) : $files;

        $form->initialize(
            $current->query->all(), $current->request->all(), $current->attributes->all(),
            $current->cookies->all(), $files, $current->server->all(), $current->getContent()
        );

        if ( $session = $current->getSession() )
        {
            $form->setSession($session);
        }

        $form->setUserResolver($current->getUserResolver());

        $form->setRouteResolver($current->getRouteResolver());
    }
}
