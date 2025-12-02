<?php

declare(strict_types=1);

namespace Au9500\LaravelAutoSingleton;

use Au9500\LaravelAutoSingleton\Attributes\AutoSingleton;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;
use RuntimeException;

/**
 * Class AutoSingletonServiceProvider
 */
class AutoSingletonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/auto-singleton.php',
            'auto-singleton'
        );

        if (! config('auto-singleton.enabled', true)) {
            return;
        }

        $this->registerAutoSingletons();
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/auto-singleton.php' => config_path('auto-singleton.php'),
        ], 'auto-singleton-config');
    }

    protected function registerAutoSingletons(): void
    {
        $directories = (array) config('auto-singleton.directories', []);

        if (empty($directories)) {
            return;
        }

        $classmap = $this->loadClassmap();

        foreach ($classmap as $class => $path) {
            if (! $this->pathMatchesDirectories($path, $directories)) {
                continue;
            }

            if (! class_exists($class)) {
                continue;
            }

            $reflection = new ReflectionClass($class);

            if ($reflection->isAbstract() || $reflection->isInterface()) {
                continue;
            }

            $attributes = $reflection->getAttributes(AutoSingleton::class);

            if (empty($attributes)) {
                continue;
            }

            /** @var AutoSingleton $attribute */
            $attribute = $attributes[0]->newInstance();

            if ($attribute->abstract !== null) {
                $this->app->singleton($attribute->abstract, $class);
            } else {
                $this->app->singleton($class);
            }
        }
    }

    /**
     * @return array<string,string>
     */
    protected function loadClassmap(): array
    {
        $classmapPath = base_path('vendor/composer/autoload_classmap.php');

        if (! file_exists($classmapPath)) {
            throw new RuntimeException('Composer classmap not found. Run `composer dump-autoload` first.');
        }

        /** @var array<string,string> $classmap */
        $classmap = require $classmapPath;

        return $classmap;
    }

    /**
     * @param  string[]  $directories
     */
    protected function pathMatchesDirectories(string $path, array $directories): bool
    {
        foreach ($directories as $directory) {
            $normalizedDirectory = str_replace('\\', '/', $directory);
            $normalizedPath = str_replace('\\', '/', $path);

            if (Str::startsWith($normalizedPath, rtrim($normalizedDirectory, '/').'/')) {
                return true;
            }
        }

        return false;
    }
}
