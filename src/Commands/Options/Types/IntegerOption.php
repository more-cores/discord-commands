<?php

namespace DiscordCommands\Commands\Options\Types;

use DiscordCommands\Commands\Options\HasMinAndMaxValues;
use DiscordCommands\Commands\Options\HasOptionChoices;
use DiscordCommands\Commands\Options\Option;

class IntegerOption extends Option
{
    use HasOptionChoices;
    use HasMinAndMaxValues;

    public const TYPE = 3;

    public function __construct(
        string $name = '',
        string $description = '',
        bool $required = false,
        ?int $minValue = null,
        ?int $maxValue = null,
    ) {
        parent::__construct(
            type: self::TYPE,
            name: $name,
            description: $description,
            required: $required,
        );

        $this->setMinValue($minValue);
        $this->setMaxValue($maxValue);
    }
}
