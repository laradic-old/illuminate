<?php

return [
    'env'             => env('APP_ENV', 'production'),
    'debug'           => env('APP_DEBUG', false),
    'url'             => env('APP_URL', 'http://localhost'),
    'timezone'        => 'UTC',
    'locale'          => 'en',
    'fallback_locale' => 'en',
    'key'             => env('APP_KEY', 'SomeRandomString'),
    'cipher'          => 'AES-256-CBC',
    'log'             => 'single',
    'providers'       => [
        # Bind sebwite / laravel foundation
        Laradic\Foundation\Providers\FoundationServiceProvider::class,
        #Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        #Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        #Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        #Illuminate\Session\SessionServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        #Illuminate\Hashing\HashServiceProvider::class,
        #Illuminate\Mail\MailServiceProvider::class,
        #Illuminate\Pagination\PaginationServiceProvider::class,
        #Illuminate\Queue\QueueServiceProvider::class,
        #Illuminate\Redis\RedisServiceProvider::class,
        #Illuminate\Translation\TranslationServiceProvider::class,
        #Illuminate\Validation\ValidationServiceProvider::class,
        #Illuminate\Broadcasting\BroadcastServiceProvider::class,
        #Illuminate\Bus\BusServiceProvider::class,
        #Illuminate\Routing\ControllerServiceProvider::class,
        #Illuminate\Cookie\CookieServiceProvider::class,
        #Illuminate\Encryption\EncryptionServiceProvider::class,
        #Radic\BladeExtensions\BladeExtensionsServiceProvider::class,

        # Bind project depencies providers
        Sebwite\Support\SupportServiceProvider::class,

        # Bind project providers
        #Laradic\Providers\MasterServiceProvider::class,
        Laradic\Providers\ResourcesServiceProvider::class,
        #SWCLI\Dev\DevServiceProvider::class,

        #SWCLI\Idea\IdeaServiceProvider::class,
        #Laradic\Config\ConfigServiceProvider::class,
        #SWCLI\Updater\UpdaterServiceProvider::class,
        #SWCLI\System\SystemServiceProvider::class,
        #SWCLI\Generators\GeneratorsServiceProvider::class,

        #SWCLI\Providers\MasterServiceProvider::class,

        #SWCLI\Idea\IdeaServiceProvider::class,

        #SWCLI\Console\ConsoleServiceProvider::class,
        #SWCLI\Projects\ProjectsServiceProvider::class,
        #SWCLI\Generators\GeneratorsServiceProvider::class
    ],
    'aliases'         => [
        'Schema' => Illuminate\Support\Facades\Schema::class,

    ]
];
