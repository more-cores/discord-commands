<?php

namespace DiscordBuilder\Commands\Types;

use DiscordBuilder\Commands\HasCommandOptions;
use PHPUnit\Framework\TestCase;

class ChatInputCommandTest extends TestCase
{
    /** @test */
    public function usesExpectedTraits()
    {
        $command = new ChatInputCommand();

        $this->assertTrue(in_array(HasCommandOptions::class, class_uses($command)));
    }
}
