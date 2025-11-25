<?php

namespace DiscordCommands\Commands\Types;

use DiscordCommands\Commands\HasCommandOptions;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ChatInputCommandTest extends TestCase
{
    #[Test]
    public function usesExpectedTraits()
    {
        $command = new ChatInputCommand();

        $this->assertTrue(in_array(HasCommandOptions::class, class_uses($command)));
    }
}
