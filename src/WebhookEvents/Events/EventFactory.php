<?php

namespace DiscordCommands\WebhookEvents\Events;

use DiscordCommands\WebhookEvents\Events\Integrations\IntegrationDeletedEvent;

class EventFactory
{
    public function make(string $type, array $data): Event
    {
        $event = match ($type) {
            IntegrationDeletedEvent::TYPE => new IntegrationDeletedEvent(),
            default => throw new UnrecognizedWebhookEvent(),
        };

        $event->hydrate($data);

        return $event;
    }
}