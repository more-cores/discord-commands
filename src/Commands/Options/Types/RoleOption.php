<?php

namespace DiscordBuilder\Commands\Options\Types;

use DiscordBuilder\Commands\Options\Option;

class RoleOption extends Option
{
    public const TYPE = 8;

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
