<?php

namespace DiscordBuilder\Commands\Interactions\Types;

use DiscordBuilder\Commands\Interactions\ExecutionResults\HasExecutionResults;
use DiscordBuilder\Commands\Interactions\Interaction;

class ChatCommandExecuted extends Interaction
{
    use HasExecutionResults;

    public const TYPE = 2;

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}