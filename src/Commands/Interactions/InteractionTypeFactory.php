<?php

namespace DiscordBuilder\Commands\Interactions;

use DiscordBuilder\Commands\Interactions\Types\ApplicationCommand;
use DiscordBuilder\Commands\Interactions\Types\ApplicationCommandAutocomplete;
use DiscordBuilder\Commands\Interactions\Types\Ping;

class InteractionTypeFactory
{
    public function make(int $type, array $request): Interaction
    {
        $interaction = match ($type) {
            Ping::TYPE                              => new Ping(),
            ApplicationCommand::TYPE                => new ApplicationCommand(),
            ApplicationCommandAutocomplete::TYPE    => new ApplicationCommandAutocomplete(),
        };

        $interaction->hydrate($request);

        return $interaction;
    }
}