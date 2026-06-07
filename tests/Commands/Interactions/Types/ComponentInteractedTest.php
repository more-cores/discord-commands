<?php

namespace DiscordCommands\Commands\Interactions\Types;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ComponentInteractedTest extends TestCase
{
    #[Test]
    public function hydratesSharedInteractionFields()
    {
        $interaction = new ComponentInteracted();

        $this->assertFalse($interaction->hasId());
        $this->assertFalse($interaction->hasGuildId());

        // Verify fields can be missing when hydrating
        $interaction->hydrate([]);

        $interaction->hydrate([
            'id' => $id = 2038585834,
            'application_id' => $appId = 12,
            'guild_id' => $guildId = '1223',
            'channel_id' => $channelId = '134988',
        ]);

        $this->assertEquals($id, $interaction->id());
        $this->assertEquals($appId, $interaction->applicationId());
        $this->assertEquals($guildId, $interaction->guildId());
        $this->assertEquals($channelId, $interaction->channelId());
    }

    #[Test]
    public function hydratesAButtonClick()
    {
        $interaction = new ComponentInteracted();

        $this->assertFalse($interaction->hasCustomId());
        $this->assertFalse($interaction->hasValues());

        $interaction->hydrate([
            'data' => [
                'custom_id' => $customId = 'approve-button',
                'component_type' => 2,
            ],
            'message' => $message = ['id' => '998877', 'content' => 'original'],
        ]);

        $this->assertTrue($interaction->hasCustomId());
        $this->assertEquals($customId, $interaction->customId());
        $this->assertEquals(2, $interaction->componentType());
        $this->assertTrue($interaction->isButton());
        $this->assertFalse($interaction->isSelectMenu());
        $this->assertFalse($interaction->hasValues());
        $this->assertEquals([], $interaction->values());

        $this->assertTrue($interaction->hasMessage());
        $this->assertEquals($message, $interaction->message());
    }

    #[Test]
    public function hydratesASelectMenuSelection()
    {
        $interaction = new ComponentInteracted();

        $interaction->hydrate([
            'data' => [
                'custom_id' => $customId = 'pick-one',
                'component_type' => 3,
                'values' => $values = ['option-1', 'option-3'],
            ],
        ]);

        $this->assertEquals($customId, $interaction->customId());
        $this->assertEquals(3, $interaction->componentType());
        $this->assertFalse($interaction->isButton());
        $this->assertTrue($interaction->isSelectMenu());
        $this->assertTrue($interaction->hasValues());
        $this->assertEquals($values, $interaction->values());
    }
}
