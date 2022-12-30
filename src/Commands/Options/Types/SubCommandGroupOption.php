<?php

namespace DiscordCommands\Commands\Options\Types;

use DiscordCommands\Commands\HasCommandOptions;
use DiscordCommands\Commands\Options\Option;

class SubCommandGroupOption extends Option
{
    use HasCommandOptions;

    public const TYPE = 2;

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
