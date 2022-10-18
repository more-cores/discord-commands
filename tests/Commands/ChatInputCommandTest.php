<?php

namespace DiscordBuilder\Commands;

use DiscordBuilder\Channel;
use PHPUnit\Framework\TestCase;

class ChatInputCommandTest extends TestCase
{
    /** @test */
    public function canAddOptions()
    {
        $this->markTestSkipped();
        $option = new Option();
        $command = new ChatInputCommand();

        $this->assertFalse($command->hasOptions());

        $command->addOption($option);

        $this->assertTrue($command->hasOptions());
        $this->assertEquals($option, $command->options()[0]);

        $json = $command->jsonSerialize();

        $this->assertArrayHasKey('custom_id', $json);
        $this->assertEquals($command->getId(), $json['custom_id']);

        $this->assertArrayHasKey('channel_types', $json);
        $this->assertTrue(in_array(Channel::TYPE_GUILD_TEXT, $json['channel_types']));
    }
}
