<?php

namespace DiscordCommands\Messages\Embed;

use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    private ?Author $author;

    public function setUp(): void
    {
        parent::setUp();

        $this->author = new Author();
    }

    /** @test */
    public function canProvideName()
    {
        $this->author->setName('');
        $this->assertEquals('', $this->author->name());

        $this->author->setName($name = uniqid());

        $this->assertEquals($name, $this->author->name());

        $this->assertArrayHasKey('name', $this->author->jsonSerialize());
        $this->assertEquals($name, $this->author->jsonSerialize()['name']);
    }

    /** @test */
    public function canProvideUrl()
    {
        $this->author->setUrl($url = uniqid());

        $this->assertEquals($url, $this->author->url());

        $this->assertArrayHasKey('url', $this->author->jsonSerialize());
        $this->assertEquals($url, $this->author->jsonSerialize()['url']);
    }

    /** @test */
    public function canProvideIconUrl()
    {
        $this->author->setIconUrl($iconUrl = uniqid());

        $this->assertEquals($iconUrl, $this->author->iconUrl());

        $this->assertArrayHasKey('icon_url', $this->author->jsonSerialize());
        $this->assertEquals($iconUrl, $this->author->jsonSerialize()['icon_url']);
    }

    /** @test */
    public function canProvideProxyIconUrl()
    {
        $this->author->setProxyIconUrl($proxyIconUrl = uniqid());

        $this->assertEquals($proxyIconUrl, $this->author->proxyIconUrl());

        $this->assertArrayHasKey('proxy_icon_url', $this->author->jsonSerialize());
        $this->assertEquals($proxyIconUrl, $this->author->jsonSerialize()['proxy_icon_url']);
    }

    /** @test */
    public function convertsToAndFromArray()
    {
        $author = new Author();
        $author->setName($name = uniqid());
        $author->setUrl($url = uniqid());
        $author->setIconUrl($iconUrl = uniqid());
        $author->setProxyIconUrl($proxyIconUrl = uniqid());

        $jsonSerialized = $author->jsonSerialize();

        $newAuthor = (new Author)->hydrate($jsonSerialized);

        $this->assertEquals($author->name(), $newAuthor->name());
        $this->assertEquals($author->url(), $newAuthor->url());
        $this->assertEquals($author->iconUrl(), $newAuthor->iconUrl());
        $this->assertEquals($author->proxyIconUrl(), $newAuthor->proxyIconUrl());
    }
}
