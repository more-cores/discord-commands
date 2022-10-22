<?php

namespace DiscordBuilder\Commands\Interactions;

use DiscordBuilder\Commands\Interactions\Types\ChatCommandExecuted;
use DiscordBuilder\Commands\Interactions\Types\ChatCommandExecutionWantsAutocompletionOptions;
use DiscordBuilder\Commands\Interactions\Types\Ping;
use PHPUnit\Framework\TestCase;

class InteractionFactoryTest extends TestCase
{
    /** @test */
    public function makesTypes()
    {
        $factory = new InteractionTypeFactory();

        $this->assertInstanceOf(
            Ping::class,
            $factory->make(Ping::TYPE, [])
        );

        $this->assertInstanceOf(
            ChatCommandExecuted::class,
            $factory->make(ChatCommandExecuted::TYPE, [])
        );

        $this->assertInstanceOf(
            ChatCommandExecutionWantsAutocompletionOptions::class,
            $factory->make(ChatCommandExecutionWantsAutocompletionOptions::TYPE, [])
        );
    }
}
