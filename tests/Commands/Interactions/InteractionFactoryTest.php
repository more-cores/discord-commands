<?php

namespace DiscordBuilder\Commands\Interactions;

use DiscordBuilder\Commands\Interactions\Types\ApplicationCommand;
use DiscordBuilder\Commands\Interactions\Types\ApplicationCommandAutocomplete;
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
            ApplicationCommand::class,
            $factory->make(ApplicationCommand::TYPE, [])
        );

        $this->assertInstanceOf(
            ApplicationCommandAutocomplete::class,
            $factory->make(ApplicationCommandAutocomplete::TYPE, [])
        );
    }
}
