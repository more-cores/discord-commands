<?php

namespace DiscordBuilder\Commands\Interactions;

use DiscordBuilder\Commands\Interactions\Types\CommandExecuted;
use DiscordBuilder\Commands\Interactions\Types\CommandExecutionWantsAutocompletionOptions;
use DiscordBuilder\Commands\Interactions\Types\Ping;

class InteractionTypeFactory
{
    public function make(int $type, array $request): Interaction
    {
        $interaction = match ($type) {
            Ping::TYPE                              => new Ping(),
            CommandExecuted::TYPE                => new CommandExecuted(),
            CommandExecutionWantsAutocompletionOptions::TYPE    => new CommandExecutionWantsAutocompletionOptions(),
        };

        $interaction->hydrate($request);

        return $interaction;
    }
}