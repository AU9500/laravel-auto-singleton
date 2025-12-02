<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Directories To Scan
    |--------------------------------------------------------------------------
    |
    | These paths are used to filter the Composer classmap when searching
    | for classes that should be treated as auto singletons.
    |
    | Use absolute or base_path()-relative paths in your application.
    |
    */
    'directories' => [
        // Example: you can adjust this in your app project:
        // base_path('app/Services'),
        // base_path('app/Domain'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable Auto Singleton Registration
    |--------------------------------------------------------------------------
    */
    'enabled' => true,
];
