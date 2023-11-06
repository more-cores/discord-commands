<?php

namespace WebhookEvents\Events;

use DiscordCommands\WebhookEvents\Events\EventFactory;
use DiscordCommands\WebhookEvents\Events\Integrations\IntegrationDeletedEvent;
use DiscordCommands\WebhookEvents\Events\UnrecognizedWebhookEvent;
use PHPUnit\Framework\TestCase;

class EventFactoryTest extends TestCase
{
    /** @test */
    public function makesTypes()
    {
        $factory = new EventFactory();

        $this->assertInstanceOf(
            IntegrationDeletedEvent::class,
            $factory->make(IntegrationDeletedEvent::TYPE, [
                'application_id' => '',
                'guild_id' => '',
                'id' => '',
            ])
        );
    }

    /** @test */
    public function throwsExceptionWhenEventNotHandled()
    {
        $this->expectException(UnrecognizedWebhookEvent::class);

        $factory = new EventFactory();

        $factory->make('not-an-event', []);
    }
}
