<?php

declare(strict_types=1);

namespace Au9500\LaravelAutoSingleton\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AutoSingleton
{
    public function __construct(
        /**
         * Optional: Abstract type (Interface or base class)
         * under which this singleton should be bound.
         *
         * If null → will be bound under the concrete class.
         */
        public ?string $abstract = null,
    ) {}
}
