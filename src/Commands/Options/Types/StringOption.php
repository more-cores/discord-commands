<?php

namespace DiscordBuilder\Commands\Options\Types;

use DiscordBuilder\Commands\Options\HasMinAndMaxLength;
use DiscordBuilder\Commands\Options\HasOptionChoices;
use DiscordBuilder\Commands\Options\Option;

class StringOption extends Option
{
    use HasOptionChoices;
    use HasMinAndMaxLength;

    public const TYPE = 3;

    public function __construct(
        string $name = '',
        string $description = '',
        bool $required = false,
        ?int $minLength = null,
        ?int $maxLength = null,
    ) {
        parent::__construct(
            type: self::TYPE,
            name: $name,
            description: $description,
            required: $required,
        );

        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }
}
