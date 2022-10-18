<?php

namespace DiscordBuilder\Components\Types\SelectMenu;

use DiscordBuilder\Channel;
use PHPUnit\Framework\TestCase;

class ChannelSelectMenuTest extends TestCase
{
    /** @test */
    public function canAddChannelTypes()
    {
        $id = 'asdf';
        $selectMenu = new ChannelSelectMenu(
            id: $id,
            channelTypes: [
                Channel::TYPE_GUILD_TEXT,
            ],
        );

        $this->assertEquals($id, $selectMenu->getId());
        $this->assertEquals(Channel::TYPE_GUILD_TEXT, $selectMenu->getChannelTypes()[0]);

        $json = $selectMenu->jsonSerialize();

        $this->assertArrayHasKey('custom_id', $json);
        $this->assertEquals($selectMenu->getId(), $json['custom_id']);

        $this->assertArrayHasKey('channel_types', $json);
        $this->assertTrue(in_array(Channel::TYPE_GUILD_TEXT, $json['channel_types']));
    }

    /** @test */
    public function canNotSpecifyChannelTypes()
    {
        $id = 'asdf';
        $selectMenu = new ChannelSelectMenu(
            id: $id,
        );

        $this->assertEquals($id, $selectMenu->getId());

        $json = $selectMenu->jsonSerialize();

        $this->assertArrayHasKey('custom_id', $json);
        $this->assertEquals($selectMenu->getId(), $json['custom_id']);

        $this->assertArrayNotHasKey('channel_types', $json);
    }
}
