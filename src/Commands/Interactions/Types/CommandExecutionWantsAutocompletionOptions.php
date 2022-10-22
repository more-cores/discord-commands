<?php

namespace DiscordBuilder\Commands\Interactions\Types;

use DiscordBuilder\Commands\Interactions\Data\HasApplicationCommandData;
use DiscordBuilder\Commands\Interactions\Interaction;

class CommandExecutionWantsAutocompletionOptions extends Interaction
{
    use HasApplicationCommandData;

    public const TYPE = 4;

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}