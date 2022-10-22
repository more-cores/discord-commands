<?php

namespace DiscordBuilder\Commands\Interactions;

use DiscordBuilder\Commands\Interactions\Types\ChatCommandExecuted;
use DiscordBuilder\Commands\Interactions\Types\ChatCommandExecutionWantsAutocompletionOptions;
use DiscordBuilder\Commands\Interactions\Types\Ping;

class InteractionTypeFactory
{
    public function make(int $type, array $request): Interaction
    {
        $interaction = match ($type) {
            Ping::TYPE                              => new Ping(),
            ChatCommandExecuted::TYPE                => new ChatCommandExecuted(),
            ChatCommandExecutionWantsAutocompletionOptions::TYPE    => new ChatCommandExecutionWantsAutocompletionOptions(),
        };

        $interaction->hydrate($request);

        return $interaction;
    }
}