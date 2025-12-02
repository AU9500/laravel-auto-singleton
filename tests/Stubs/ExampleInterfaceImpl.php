<?php

declare(strict_types=1);

namespace Au9500\LaravelAutoSingleton\Tests\Stubs;

use Au9500\LaravelAutoSingleton\Attributes\AutoSingleton;

#[AutoSingleton(ExampleInterface::class)]
class ExampleInterfaceImpl implements ExampleInterface {}
