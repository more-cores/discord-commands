<?php

namespace DiscordCommands\Commands\Interactions;

use DiscordCommands\Commands\Interactions\Types\ChatCommandExecuted;
use DiscordCommands\Commands\Interactions\Types\ChatCommandExecutionWantsAutocompletionOptions;
use DiscordCommands\Commands\Interactions\Types\InteractionCreated;
use DiscordCommands\Commands\Interactions\Types\ModalSubmitted;
use DiscordCommands\Commands\Interactions\Types\Ping;

class InteractionTypeFactory
{
    public function make(string|int $type, array $request): Interaction
    {
        $interaction = match ($type) {
            Ping::TYPE                                              => new Ping(),
            ChatCommandExecuted::TYPE                               => new ChatCommandExecuted(),
            ChatCommandExecutionWantsAutocompletionOptions::TYPE    => new ChatCommandExecutionWantsAutocompletionOptions(),
            ModalSubmitted::TYPE                                    => new ModalSubmitted(),
            InteractionCreated::TYPE                                => new InteractionCreated(),
        };

        $interaction->hydrate($request);

        return $interaction;
    }
}