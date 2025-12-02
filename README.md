# 🔗 Laravel Auto Singleton

Automatically register classes as singletons in the Laravel service container using a clean PHP 8 attribute.  
No more manual container bindings — just add an attribute and you're done. ⚡

---

## ✨ Features

- 🧩 Register any class as a singleton using a simple PHP 8 attribute
- 🎯 Optional: Bind an interface to its implementation
- 🔍 Scans only the directories you choose
- 🔌 Zero boilerplate — no service provider bindings required
- ⚙️ Respects Laravel config and auto-discovery
- 🚀 Works with Laravel 10, 11, 12
- 🪶 Lightweight and dependency-free

---

## 📦 Installation

Install via Composer:

    composer require au9500/laravel-auto-singleton

Publish the configuration file:

    php artisan vendor:publish --tag=auto-singleton-config

This creates:

    config/auto-singleton.php

---

## ⚙️ Configuration

Example contents of config/auto-singleton.php:

    return [
        'enabled' => true,

        'directories' => [
            base_path('app/Services'),
            base_path('app/Domain'),
        ],
    ];

`directories` determines where attribute scanning is performed.

---

## 🛠 Usage

### 1. 🔒 Register a simple singleton

    use Au9500\LaravelAutoSingleton\Attributes\AutoSingleton;

    #[AutoSingleton]
    class PaymentService {
    }

Inject anywhere:

    public function __construct(PaymentService $service) {
        $this->service = $service;
    }

Laravel now resolves this service as a singleton.

---

### 2. 🎭 Bind an interface

    interface UserRepository {}

    #[AutoSingleton(UserRepository::class)]
    class EloquentUserRepository implements UserRepository {
    }

Now you may type-hint the interface:

    public function __construct(UserRepository $repo) {
        $this->repo = $repo;
    }

Laravel automatically binds the interface → implementation as a singleton.

---

### 3. 🚫 Disable auto-registration

In your config:

    'enabled' => false,

This disables all automatic registration.

---

## 🔍 How It Works

1. Laravel boots and loads this package's ServiceProvider
2. Config tells the provider which directories to scan
3. The Composer classmap is inspected
4. Every class in the configured directories is checked via Reflection
5. If it has the AutoSingleton attribute:
    - It is registered as a singleton
6. If the attribute specifies an abstract/interface:
    - That abstract is bound to the class

No extra code. No boilerplate. Zero maintenance.

---

## 🧪 Testing

The package ships with full PHPUnit and Orchestra Testbench support.  
Run the test suite with:

    vendor/bin/phpunit

Tests cover:

- ✔️ Basic singleton registration
- ✔️ Interface binding
- ✔️ Ignoring non-attributed classes
- ✔️ Config disabling behavior
- ✔️ Directory filtering

---

## 🛡 Requirements

- PHP 8.2+
- Laravel 10, 11, or 12

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a Pull Request

---

## 📄 License

MIT License.
