<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super-admin' => [
            'users' => 'c,r,u,d',
            'roles' => 'c,r,u,d',  // Roles && assign permission
            'managers' => 'c,r,u,d',
            'marks' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'structure' => 'r,u',
            'merchants' => 'r',
            'merchants-products' => 'r,c,u,d',
            'profile' => 'r,u',
        ],
        'admin' => [
            'users' => 'r',
            'profile' => 'r,u',
            'merchants' => 'r',
            'merchants-products' => 'r,c,u,d',
        ],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
