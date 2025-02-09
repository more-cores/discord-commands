<?php

namespace DiscordCommands\Commands\Interactions\Types;

use DiscordCommands\Commands\Interactions\Interaction;

class InteractionCreated extends Interaction
{
    public const TYPE = 'INTERACTION_CREATE';

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}