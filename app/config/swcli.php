<?php

return [
    // Global only config
    'first_run'    => true,
    'project_file' => '.sebwite.php',

    // Global & Project
    'auth'         => [
        'github'    => [ 'token' => '' ],
        'bitbucket' => [ 'key' => '', 'secret' => '' ]
    ],
    'generator'    => [
        'stubs_dir' => __DIR__ . '/../resources/stubs',
    ],
    'update'       => [
        'manifest_file' => ''
    ],
    'workbench'    => [
        'dir' => 'workbench'
    ],
    'idea'         => [
        'dir'     => '.idea',
        // vcs: Folders to search in for git roots
        'vcs'     => [ 'app', 'workbench' ],
        // folders prefixes/namespaces
        'folders' => [
            // resource: {prefix} => {folders}
            'resource' => [
                'config' => [ '{{ $config["swcli.workbench.dir"] }}/*/*/config' ],
                'views'  => [ '{{ $config["swcli.workbench.dir"] }}/*/*/resources/views' ],
                'assets' => [ '{{ $config["swcli.workbench.dir"] }}/*/*/resources/assets' ],
                'themes' => [ '{{ $config["swcli.workbench.dir"] }}/*/*/themes/*/*/*/{views,assets}' ]
            ],
            // source: composer.json paths, will use autoload psr-0 and psr-4 to apply src namespace prefix
            'source'   => [
                'composer.json',
                'workbench/*/*/composer.json'
            ],
            // tests: composer.json paths, will use autoload psr-0 and psr-4 to apply test namespace prefix
            'tests'    => [

            ]
        ],
    ]
];
