<?php

namespace DiscordBuilder\Commands\Interactions;

use DiscordBuilder\Commands\Interactions\Types\CommandExecuted;
use DiscordBuilder\Commands\Interactions\Types\CommandExecutionWantsAutocompletionOptions;
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
            CommandExecuted::class,
            $factory->make(CommandExecuted::TYPE, [])
        );

        $this->assertInstanceOf(
            CommandExecutionWantsAutocompletionOptions::class,
            $factory->make(CommandExecutionWantsAutocompletionOptions::TYPE, [])
        );
    }
}
