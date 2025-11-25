<?php

namespace DiscordCommands\Messages\Embed;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class FooterTest extends TestCase
{
    private ?Footer $footer;

    public function setUp(): void
    {
        parent::setUp();

        $this->footer = new Footer();
    }

    #[Test]
    public function canProvideUrl()
    {
        $this->footer->setIconUrl($iconUrl = uniqid());

        $this->assertEquals($iconUrl, $this->footer->iconUrl());

        $this->assertArrayHasKey('icon_url', $this->footer->jsonSerialize());
        $this->assertEquals($iconUrl, $this->footer->jsonSerialize()['icon_url']);
    }

    #[Test]
    public function canProvideProxyIconUrl()
    {
        $this->footer->setProxyIconUrl($proxyIconUrl = uniqid());

        $this->assertEquals($proxyIconUrl, $this->footer->proxyIconUrl());

        $this->assertArrayHasKey('proxy_icon_url', $this->footer->jsonSerialize());
        $this->assertEquals($proxyIconUrl, $this->footer->jsonSerialize()['proxy_icon_url']);
    }

    #[Test]
    public function convertsToAndFromArray()
    {
        $footer = new Footer();
        $footer->setText($text = uniqid());
        $footer->setIconUrl($iconUrl = uniqid());
        $footer->setProxyIconUrl($proxyIconUrl = uniqid());

        $jsonSerialized = $footer->jsonSerialize();

        $newFooter = (new Footer())->hydrate($jsonSerialized);

        $this->assertEquals($footer->text(), $newFooter->text());
        $this->assertEquals($footer->iconUrl(), $newFooter->iconUrl());
        $this->assertEquals($footer->proxyIconUrl(), $newFooter->proxyIconUrl());
    }
}
