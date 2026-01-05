<?php

return [
    'tenant_model' => \App\Models\School::class,

    'jobs' => 'sync',

    'migrations' => [
        //
    ],

    'database' => null,

    'cache' => [
        'tag_base' => 'tenant:',
    ],

    'filesystem' => [
        'suffix_base' => 'tenant',
        'disks' => [
            'local',
            'public',
            's3',
        ],
    ],

    'redis' => [
        'prefix_base' => 'tenant',
        'prefixed_connections' => [
            'default',
            'cache',
            'queue',
        ],
    ],
];
