<?php

namespace DiscordCommands\WebhookEvents;

class WebhookEventRequestFactory
{
    public function make(string $type, array $request): BatchedEvents
    {
        $interaction = match ($type) {
            BatchedEvents::TYPE => new BatchedEvents(),
        };

        $interaction->hydrate($request);

        return $interaction;
    }
}