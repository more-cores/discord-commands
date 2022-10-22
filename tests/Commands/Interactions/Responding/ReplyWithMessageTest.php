<?php

namespace DiscordBuilder\Commands\Interactions\Responding\Responses;

use DiscordBuilder\Commands\Interactions\Responding\ReplyWithMessage;
use DiscordBuilder\Messages\Components\Types\Buttons\PrimaryButton;
use DiscordBuilder\Messages\Embed\Embed;
use PHPUnit\Framework\TestCase;

class ReplyWithMessageTest extends TestCase
{
    /** @test */
    public function serializes()
    {
        $response = new ReplyWithMessage(
            content: $content = 'something-here',
        );

        $this->assertEquals($content, $response->content());

        $json = $response->jsonSerialize();

        $this->assertEquals($content, $json['data']['content']);
    }

    /** @test */
    public function serializesFlags()
    {
        $response = new ReplyWithMessage();

        $response->suppressEmbeds();

        $json = $response->jsonSerialize();

        $this->assertArrayHasKey('flags', $json['data']);

        if (!(ReplyWithMessage::FLAG_SUPPRESS_EMBEDS & $json['data']['flags'])) {
            $this->assertTrue(false, 'suppress embeds bitwise operator not applied');
        }

        $response->onlyVisibleToCommandIssuer();

        $json = $response->jsonSerialize();
        if (!(ReplyWithMessage::FLAG_EPHEMERAL & $json['data']['flags'])) {
            $this->assertTrue(false, 'ephemeral bitwise operator not applied');
        }
    }

    /** @test */
    public function verifyUsesComponents()
    {
        $response = new ReplyWithMessage();

        $this->assertFalse($response->hasComponents());

        $compId = '34';
        $component = new PrimaryButton($compId);

        $response->addComponent($component);

        $this->assertTrue($response->hasComponents());

        $this->assertEquals($compId, $response->components()[0]->id());

        $json = $response->jsonSerialize();

        $this->assertArrayHasKey('components', $json['data']);
        $this->assertEquals($compId, $json['data']['components'][0]['custom_id']);
    }

    /** @test */
    public function verifyUsesEmbeds()
    {
        $response = new ReplyWithMessage();

        $this->assertFalse($response->hasEmbeds());

        $title = 'something';
        $embed = new Embed(
            title: $title,
        );

        $response->addEmbed($embed);

        $this->assertTrue($response->hasEmbeds());

        $this->assertEquals($title, $response->embeds()[0]->title());

        $json = $response->jsonSerialize();

        $this->assertArrayHasKey('embeds', $json['data']);
        $this->assertEquals($title, $json['data']['embeds'][0]['title']);
    }
}
