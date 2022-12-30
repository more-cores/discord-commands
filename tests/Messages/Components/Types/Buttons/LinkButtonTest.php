<?php

namespace DiscordCommands\Messages\Components\Types\Buttons;

use PHPUnit\Framework\TestCase;

class LinkButtonTest extends TestCase
{
    /** @test */
    public function canBeConstructedAndJsonified()
    {
        $url = 'http://google.com';
        $button = new LinkButton($url);

        $this->assertEquals($url, $button->url());

        $json = $button->jsonSerialize();
        $this->assertArrayHasKey('url', $json);
        $this->assertEquals($button->url(), $json['url']);
    }
}
