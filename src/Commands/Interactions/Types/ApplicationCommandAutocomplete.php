<?php

namespace DiscordBuilder\Commands\Interactions\Types;

use DiscordBuilder\Commands\Interactions\Data\HasApplicationCommandData;
use DiscordBuilder\Commands\Interactions\Interaction;

class ApplicationCommandAutocomplete extends Interaction
{
    use HasApplicationCommandData;

    public const TYPE = 4;

    protected array $data = [];

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}