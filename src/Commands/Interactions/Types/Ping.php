<?php

namespace DiscordBuilder\Commands\Interactions\Types;

use DiscordBuilder\Commands\Interactions\Interaction;

class Ping extends Interaction
{
    public const TYPE = 1;

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}