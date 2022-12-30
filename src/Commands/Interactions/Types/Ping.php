<?php

namespace DiscordCommands\Commands\Interactions\Types;

use DiscordCommands\Commands\Interactions\Interaction;

class Ping extends Interaction
{
    public const TYPE = 1;

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}