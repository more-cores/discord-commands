<?php

namespace DiscordCommands\WebhookEvents;

use DiscordCommands\Hydrateable;
use DiscordCommands\WebhookEvents\Events\EventFactory;

class BatchedEvents implements Hydrateable
{
    public const TYPE = 'BATCHED_EVENTS';

    private string $appId;
    private array $events = [];

    public function appId(): string
    {
        return $this->appId;
    }

    public function events(): array
    {
        return $this->events;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['application_id'])) {
            $this->appId = $array['application_id'];
        }

        if (isset($array['data']) && count($array['data']) > 0) {
            $eventFactory = new EventFactory();
            foreach($array['data'] as $eventData) {
                $this->events[] = $eventFactory->make($eventData['type'], $eventData['data']);
            }
        }

        return $this;
    }
}