<?php

namespace DiscordCommands\Commands\Interactions\Types;

use DiscordCommands\Commands\Interactions\ExecutionResults\HasExecutionResults;
use DiscordCommands\Commands\Interactions\Interaction;

class ChatCommandExecutionWantsAutocompletionOptions extends Interaction
{
    use HasExecutionResults;

    public const TYPE = 4;

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}