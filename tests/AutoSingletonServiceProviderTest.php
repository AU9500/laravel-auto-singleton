<?php

declare(strict_types=1);

namespace Au9500\LaravelAutoSingleton\Tests;

use Au9500\LaravelAutoSingleton\Tests\Stubs\ExampleInterface;
use Au9500\LaravelAutoSingleton\Tests\Stubs\ExampleInterfaceImpl;
use Au9500\LaravelAutoSingleton\Tests\Stubs\PlainService;
use Au9500\LaravelAutoSingleton\Tests\Stubs\SimpleAttributedService;
use Au9500\LaravelAutoSingleton\Tests\Support\TestAutoSingletonServiceProvider;

class AutoSingletonServiceProviderTest extends TestCase
{
    protected function registerProviderWithDirectories(array $directories): void
    {
        config(['auto-singleton.directories' => $directories]);
        config(['auto-singleton.enabled' => true]);

        $provider = new TestAutoSingletonServiceProvider($this->app);
        $provider->register();
    }

    public function test_registers_attributed_class_as_singleton(): void
    {
        $this->registerProviderWithDirectories([
            base_path('tests/Stubs'),
        ]);

        $this->assertTrue($this->app->bound(SimpleAttributedService::class));

        $instance1 = $this->app->make(SimpleAttributedService::class);
        $instance2 = $this->app->make(SimpleAttributedService::class);

        $this->assertSame($instance1, $instance2, 'Attributed class was not registered as singleton.');
    }

    public function test_registers_attributed_class_with_abstract_interface(): void
    {
        $this->registerProviderWithDirectories([
            base_path('tests/Stubs'),
        ]);

        $this->assertTrue($this->app->bound(ExampleInterface::class));

        $impl = $this->app->make(ExampleInterface::class);

        $this->assertInstanceOf(ExampleInterfaceImpl::class, $impl);

        $impl2 = $this->app->make(ExampleInterface::class);

        $this->assertSame($impl, $impl2, 'Interface binding is not a singleton.');
    }

    public function test_ignores_classes_without_attribute(): void
    {
        $this->registerProviderWithDirectories([
            base_path('tests/Stubs'),
        ]);

        $this->assertFalse(
            $this->app->bound(PlainService::class),
            'PlainService should not be auto-registered as singleton.'
        );
    }

    public function test_does_not_register_when_disabled_in_config(): void
    {
        config(['auto-singleton.directories' => [
            base_path('tests/Stubs'),
        ]]);
        config(['auto-singleton.enabled' => false]);

        $provider = new TestAutoSingletonServiceProvider($this->app);
        $provider->register();

        $this->assertFalse($this->app->bound(SimpleAttributedService::class));
        $this->assertFalse($this->app->bound(ExampleInterface::class));
    }

    public function test_does_nothing_when_no_directories_configured(): void
    {
        config(['auto-singleton.directories' => []]);
        config(['auto-singleton.enabled' => true]);

        $provider = new TestAutoSingletonServiceProvider($this->app);
        $provider->register();

        $this->assertFalse($this->app->bound(SimpleAttributedService::class));
        $this->assertFalse($this->app->bound(ExampleInterface::class));
        $this->assertFalse($this->app->bound(PlainService::class));
    }
}
