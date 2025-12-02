# Laravel Auto Singleton

A Laravel package that automatically registers classes as singletons using a PHP 8 attribute.  
Add the AutoSingleton attribute to a class and it becomes a singleton during application boot.

------------------------------------------------------------
FEATURES
------------------------------------------------------------

- Register classes as singletons via PHP 8 attributes
- Optionally bind an interface: AutoSingleton(Interface::class)
- No manual service provider bindings
- Scans only the directories you configure
- Extremely lightweight
- Supports Laravel 10, 11, 12

------------------------------------------------------------
INSTALLATION
------------------------------------------------------------

Run:

    composer require au9500/laravel-auto-singleton

Publish the config file:

    php artisan vendor:publish --tag=auto-singleton-config

This creates:

    config/auto-singleton.php

------------------------------------------------------------
CONFIGURATION
------------------------------------------------------------

Example contents of config/auto-singleton.php:

    return [
        'enabled' => true,

        'directories' => [
            base_path('app/Services'),
            base_path('app/Domain'),
        ],
    ];

Only classes inside these directories will be scanned.

------------------------------------------------------------
USAGE
------------------------------------------------------------

1. BASIC SINGLETON

Add this to a class:

    use Au9500\LaravelAutoSingleton\Attributes\AutoSingleton;

    #[AutoSingleton]
    class PaymentService {
    }

Laravel now automatically binds PaymentService as a singleton.  
You can inject it like this:

    public function __construct(PaymentService $service) {
        $this->service = $service;
    }

2. SINGLETON WITH INTERFACE BINDING

   interface UserRepository {}

   #[AutoSingleton(UserRepository::class)]
   class EloquentUserRepository implements UserRepository {
   }

Now this works:

    public function __construct(UserRepository $repo) {
        $this->repo = $repo;
    }

The interface is automatically bound to its implementation.

3. DISABLING AUTO REGISTRATION

In config/auto-singleton.php:

    'enabled' => false,

------------------------------------------------------------
HOW IT WORKS
------------------------------------------------------------

1. Laravel boots the service provider
2. The provider reads configured directories
3. The composer classmap is scanned
4. All classes in those directories are inspected via Reflection
5. If a class has #[AutoSingleton], it is auto-bound
6. If an abstract/interface is provided, it binds abstract -> concrete
7. All bindings are singletons

------------------------------------------------------------
TESTING
------------------------------------------------------------

This package includes full PHPUnit + Orchestra Testbench tests.  
Run:

    vendor/bin/phpunit

Included tests check:

- singleton registration
- interface binding
- ignoring classes without attributes
- disabling via config
- directory filtering

------------------------------------------------------------
REQUIREMENTS
------------------------------------------------------------

- PHP 8.2 or later
- Laravel 10, 11, or 12

------------------------------------------------------------
CONTRIBUTING
------------------------------------------------------------

1. Fork the repository
2. Create a feature branch
3. Commit changes
4. Open a pull request

------------------------------------------------------------
LICENSE
------------------------------------------------------------

MIT license.
