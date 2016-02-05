<?php

return [
    'paths' => [
        realpath(export_path('resources/views')),
    ],
    'compiled' => "{{ app()->storagePath() }}/framework/views"

];
