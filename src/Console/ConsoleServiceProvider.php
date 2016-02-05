<?php

namespace Laradic\Console;

use Laradic\Support\Console\ConsoleServiceProvider as BaseConsoleProvider;

class ConsoleServiceProvider extends BaseConsoleProvider
{
    protected $dir = __DIR__;

   # protected $finder = true;

    protected $namespace = 'Laradic\\Commands';

    protected $prefix = 'commands.sebwite.development.';

    protected $reject = [  ];

    protected $exclude = ['*BaseCommand.php' ];


    protected $path = '{dir}{sep}..{sep}Commands';

}
