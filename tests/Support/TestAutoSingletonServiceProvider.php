<?php

declare(strict_types=1);

namespace Au9500\LaravelAutoSingleton\Tests\Support;

use Au9500\LaravelAutoSingleton\AutoSingletonServiceProvider;
use Au9500\LaravelAutoSingleton\Tests\Stubs\ExampleInterfaceImpl;
use Au9500\LaravelAutoSingleton\Tests\Stubs\PlainService;
use Au9500\LaravelAutoSingleton\Tests\Stubs\SimpleAttributedService;

class TestAutoSingletonServiceProvider extends AutoSingletonServiceProvider
{
    /**
     * We override the classmap to use only our test classes.
     *
     * @return array<string,string>
     */
    protected function loadClassmap(): array
    {
        return [
            SimpleAttributedService::class => base_path('tests/Stubs/SimpleAttributedService.php'),
            ExampleInterfaceImpl::class => base_path('tests/Stubs/ExampleInterfaceImpl.php'),
            PlainService::class => base_path('tests/Stubs/PlainService.php'),
        ];
    }
}
