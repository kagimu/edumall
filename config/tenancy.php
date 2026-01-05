<?php

return [

    'tenant_model' => \App\Models\School::class,

    'table_names' => [

        'tenants' => 'schools',

        'domains' => 'domains',

    ],

    'database' => [

        'central_databases' => [

            'mysql' => env('DB_DATABASE', 'laravel'),

        ],

        'database_name' => 'school_{id}',

        'template_tenant_database' => null,

    ],

    'cache' => [

        'store' => 'redis',

        'tag_base' => 'tenant:',

    ],

    'filesystem' => [

        'disk' => 'public',

        'suffix_base' => 'tenant',

    ],

    'jobs' => [

        'queue' => 'default',

    ],

    'redis' => [

        'prefix_base' => 'tenant',

    ],

];