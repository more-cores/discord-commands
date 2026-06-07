<?php

namespace DiscordCommands\Commands\Interactions\Responding\Responses;

use DiscordCommands\Commands\Interactions\Responding\UpdateMessage;
use DiscordCommands\Messages\Components\Types\Buttons\PrimaryButton;
use DiscordCommands\Messages\Embed\Embed;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UpdateMessageTest extends TestCase
{
    #[Test]
    public function serializes()
    {
        $response = new UpdateMessage(
            content: $content = 'something-here',
        );

        $this->assertEquals($content, $response->content());

        $json = $response->jsonSerialize();

        $this->assertEquals(UpdateMessage::TYPE, $json['type']);
        $this->assertEquals(7, $json['type']);
        $this->assertEquals($content, $json['data']['content']);
    }

    #[Test]
    public function serializesFlags()
    {
        $response = new UpdateMessage();

        $response->withoutExpandingEmbeds();

        $json = $response->jsonSerialize();

        $this->assertArrayHasKey('flags', $json['data']);

        if (!(UpdateMessage::FLAG_SUPPRESS_EMBEDS & $json['data']['flags'])) {
            $this->assertTrue(false, 'suppress embeds bitwise operator not applied');
        }
    }

    #[Test]
    public function verifyUsesComponents()
    {
        $response = new UpdateMessage();

        $this->assertFalse($response->hasComponents());

        $compId = '34';
        $response->addComponent(new PrimaryButton($compId));

        $this->assertTrue($response->hasComponents());

        $json = $response->jsonSerialize();

        $this->assertArrayHasKey('components', $json['data']);
        $this->assertEquals($compId, $json['data']['components'][0]['custom_id']);
    }

    #[Test]
    public function verifyUsesEmbeds()
    {
        $response = new UpdateMessage();

        $this->assertFalse($response->hasEmbeds());

        $title = 'something';
        $response->addEmbed(new Embed(title: $title));

        $this->assertTrue($response->hasEmbeds());

        $json = $response->jsonSerialize();

        $this->assertArrayHasKey('embeds', $json['data']);
        $this->assertEquals($title, $json['data']['embeds'][0]['title']);
    }
}
