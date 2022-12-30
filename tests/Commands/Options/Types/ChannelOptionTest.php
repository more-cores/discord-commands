<?php

namespace DiscordCommands\Commands\Options;

use DiscordCommands\Channel;
use DiscordCommands\Commands\Options\Types\ChannelOption;
use PHPUnit\Framework\TestCase;

class ChannelOptionTest extends TestCase
{
    /** @test */
    public function serializesOptions()
    {
        $channelType = Channel::TYPE_GUILD_VOICE;
        $option = new ChannelOption();

        $this->assertFalse($option->hasChannelTypes());

        $option->addChannelType($channelType);

        $this->assertTrue($option->hasChannelTypes());

        $this->assertEquals($channelType, $option->channelTypes()[0]);

        $json = $option->jsonSerialize();

        $this->assertArrayHasKey('channel_types', $json);
        $this->assertEquals($channelType, $json['channel_types'][0]);
    }
}
