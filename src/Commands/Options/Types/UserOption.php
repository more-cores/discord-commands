<?php

namespace DiscordBuilder\Commands\Options\Types;

use DiscordBuilder\Commands\Options\Option;

class UserOption extends Option
{
    public const TYPE = 6;

    public function __construct(
        string $name = '',
        string $description = '',
        bool $required = false,
    ) {
        parent::__construct(
            type: self::TYPE,
            name: $name,
            description: $description,
            required: $required,
        );
    }
}
