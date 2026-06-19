<?php

namespace WebhookEvents;

use DiscordCommands\WebhookEvents\BatchedEvents;
use DiscordCommands\WebhookEvents\WebhookEventRequestFactory;
use PHPUnit\Framework\TestCase;

class WebhookEventRequestFactoryTest extends TestCase
{
    /** @test */
    public function makesTypes()
    {
        $factory = new WebhookEventRequestFactory();

        $this->assertInstanceOf(
            BatchedEvents::class,
            $factory->make(BatchedEvents::TYPE, [])
        );
    }
}
