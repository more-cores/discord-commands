<?php

namespace DiscordCommands\WebhookEvents\Events\Integrations;

use DiscordCommands\WebhookEvents\Events\Event;

class IntegrationDeletedEvent implements Event
{
    public const TYPE = 'INTEGRATION_DELETE';

    private ?string $appId;
    private ?string $guildId;
    private ?string $id;

    public function appId(): string
    {
        return $this->appId;
    }

    public function guildId(): string
    {
        return $this->guildId;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function hydrate(array $array): self
    {
        $this->appId = $array['application_id'];
        $this->guildId = $array['guild_id'];
        $this->id = $array['id'];

        return $this;
    }
}