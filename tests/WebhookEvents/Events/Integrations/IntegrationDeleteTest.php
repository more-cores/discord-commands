<?php

namespace WebhookEvents\Events\Integrations;

use DiscordCommands\WebhookEvents\Events\Integrations\IntegrationDeletedEvent;
use PHPUnit\Framework\TestCase;

class IntegrationDeleteTest extends TestCase
{
    private IntegrationDeletedEvent $event;

    protected function setUp(): void
    {
        parent::setUp();

        $this->event = new IntegrationDeletedEvent();
    }

    /** @test */
    public function serializesData()
    {
        $appId = 'my-app-id';
        $guildId = 'my-guild-id';
        $eventId = 'my-event-id';
        $this->event->hydrate([
            'application_id' => $appId,
            'guild_id' => $guildId,
            'id' => $eventId,
        ]);

        $this->assertEquals($appId, $this->event->appId());
        $this->assertEquals($guildId, $this->event->guildId());
        $this->assertEquals($eventId, $this->event->id());
    }
}
