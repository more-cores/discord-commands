<?php

namespace DiscordBuilder\Commands\Interactions\Types;

use DiscordBuilder\Commands\Interactions\Data\HasApplicationCommandData;
use DiscordBuilder\Commands\Interactions\Interaction;

class CommandExecuted extends Interaction
{
    use HasApplicationCommandData;

    public const TYPE = 2;

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}