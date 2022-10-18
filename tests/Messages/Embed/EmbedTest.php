<?php

namespace DiscordBuilder\Messages\Embed;

use DateTime;
use PHPUnit\Framework\TestCase;

class EmbedTest extends TestCase
{
    /** @var Embed */
    protected $embed;

    public function setUp(): void
    {
        parent::setUp();

        $this->embed = new Embed();
    }

    /** @test */
    public function canProvideTitle()
    {
        $this->assertFalse($this->embed->hasTitle());
        $this->embed->setTitle($title = uniqid());

        $this->assertTrue($this->embed->hasTitle());
        $this->assertEquals($title, $this->embed->title());

        $this->assertArrayHasKey('title', $this->embed->jsonSerialize());
        $this->assertEquals($title, $this->embed->jsonSerialize()['title']);
    }

    /** @test */
    public function canProvideUrl()
    {
        $this->assertFalse($this->embed->hasUrl());
        $this->embed->setUrl($url = uniqid());

        $this->assertTrue($this->embed->hasUrl());
        $this->assertEquals($url, $this->embed->url());

        $this->assertArrayHasKey('url', $this->embed->jsonSerialize());
        $this->assertEquals($url, $this->embed->jsonSerialize()['url']);
    }

    /** @test */
    public function canProvideTimestamp()
    {
        $this->assertFalse($this->embed->hasTimestamp());
        $this->embed->setTimestamp($timestamp = new DateTime());

        $this->assertTrue($this->embed->hasTimestamp());
        $this->assertEquals($timestamp, $this->embed->timestamp());

        $this->assertArrayHasKey('timestamp', $this->embed->jsonSerialize());
        $this->assertEquals($timestamp->format(DateTime::ATOM), $this->embed->jsonSerialize()['timestamp']);
    }

    /** @test */
    public function canProvideDescription()
    {
        $this->embed->setDescription($description = uniqid());

        $this->assertEquals($description, $this->embed->description());

        $this->assertArrayHasKey('description', $this->embed->jsonSerialize());
        $this->assertEquals($description, $this->embed->jsonSerialize()['description']);
    }

    /** @test */
    public function canProvideColor()
    {
        $this->assertFalse($this->embed->hasColor());
        $this->embed->setColor($color = time());

        $this->assertEquals($color, $this->embed->color());

        $this->assertTrue($this->embed->hasColor());
        $this->assertArrayHasKey('color', $this->embed->jsonSerialize());
        $this->assertEquals($color, $this->embed->jsonSerialize()['color']);
    }

    /** @test */
    public function canSetColorBasedOnRGB()
    {
        $this->embed->setColorRGB(62, 143, 64);

        $this->assertEquals(4099904, $this->embed->color());
    }

    /** @test */
    public function canSetAuthorObject()
    {
        $author = new Author(
            name: $name = uniqid(),
        );
        $this->embed->setAuthor($author);

        $this->assertEquals($author, $this->embed->author());

        $this->assertArrayHasKey('author', $this->embed->jsonSerialize());
        $this->assertEquals($name, $this->embed->jsonSerialize()['author']['name']);
    }

    /** @test */
    public function canSetAuthorByUrlAndDimensions()
    {
        $name = uniqid();
        $url = uniqid();
        $iconUrl = uniqid();
        $this->assertFalse($this->embed->hasAuthor());
        $this->embed->setAuthor($name, $url, $iconUrl);

        $this->assertTrue($this->embed->hasAuthor());
        $this->assertEquals($name, $this->embed->author()->name());
        $this->assertEquals($url, $this->embed->author()->url());
        $this->assertEquals($iconUrl, $this->embed->author()->iconUrl());
    }

    /** @test */
    public function canAddMultipleFields()
    {
        $this->assertFalse($this->embed->hasFields());
        $this->assertCount(0, $this->embed->fields());

        $firstField = new Field();
        $firstField->setName($firstName = uniqid());
        $this->embed->addField($firstField);

        $this->assertTrue($this->embed->hasFields());
        $this->assertCount(1, $this->embed->fields());

        $secondField = new Field();
        $secondField->setName($secondName = uniqid());
        $this->embed->addField($secondField);

        $this->assertCount(2, $this->embed->fields());

        $this->assertArrayHasKey('fields', $this->embed->jsonSerialize());
        $this->assertEquals($firstName, $this->embed->jsonSerialize()['fields'][0]['name']);
        $this->assertEquals($secondName, $this->embed->jsonSerialize()['fields'][1]['name']);
    }

    /** @test */
    public function canSetFieldByNameValueAndInline()
    {
        $fieldName = uniqid();
        $value = uniqid();
        $inline = true;
        $this->embed->addField($fieldName, $value, $inline);

        $this->assertEquals($fieldName, $this->embed->fields()[0]->name());
        $this->assertEquals($value, $this->embed->fields()[0]->value());
        $this->assertTrue($this->embed->fields()[0]->isInline());
    }

    /** @test */
    public function canSetImageUrl()
    {
        $this->assertFalse($this->embed->hasImage());
        $this->embed->setImageUrl($imageUrl = uniqid());

        $this->assertTrue($this->embed->hasImage());
        $this->assertEquals($imageUrl, $this->embed->imageUrl());

        $this->assertArrayHasKey('image', $this->embed->jsonSerialize());
        $this->assertEquals($imageUrl, $this->embed->jsonSerialize()['image']['url']);
    }

    /** @test */
    public function canSetThumbnailUrl()
    {
        $this->assertFalse($this->embed->hasThumbnail());
        $this->embed->setThumbnailUrl($imageUrl = uniqid());

        $this->assertTrue($this->embed->hasThumbnail());
        $this->assertEquals($imageUrl, $this->embed->thumbnailUrl());

        $this->assertArrayHasKey('thumbnail', $this->embed->jsonSerialize());
        $this->assertEquals($imageUrl, $this->embed->jsonSerialize()['thumbnail']['url']);
    }

    /** @test */
    public function canSetFooterObject()
    {
        $footer = new Footer();
        $footer->setText($text = uniqid());
        $this->assertFalse($this->embed->hasFooter());
        $this->embed->setFooter($footer);

        $this->assertTrue($this->embed->hasFooter());
        $this->assertEquals($footer, $this->embed->footer());

        $this->assertArrayHasKey('footer', $this->embed->jsonSerialize());
        $this->assertEquals($text, $this->embed->jsonSerialize()['footer']['text']);
    }

    /** @test */
    public function canSetFooterByTextAndIconUrl()
    {
        $text = uniqid();
        $iconUrl = uniqid();
        $this->embed->setFooter($text, $iconUrl);

        $this->assertEquals($text, $this->embed->footer()->text());
        $this->assertEquals($iconUrl, $this->embed->footer()->iconUrl());
    }

    /** @test */
    public function convertsToAndFromArray()
    {
        $embed = new Embed();
        $embed->setTitle($title = uniqid());
        $embed->setDescription($description = uniqid());
        $embed->setUrl($url = uniqid());
        $embed->setTimestamp($timestamp = new DateTime('5 days ago'));
        $embed->setColor($color = uniqid());
        $embed->setFooter($footer = new Footer(
            text: $footerText = uniqid(),
        ));
        $embed->setImageUrl($imageUrl = uniqid());
        $embed->setThumbnailUrl($thumbnailUrl = uniqid());
        $embed->setAuthor($author = new Author(
            name: $authorName = uniqid(),
        ));
        $embed->addField($field = new Field(
            name: $fieldName = uniqid(),
        ));

        $jsonSerialized = $embed->jsonSerialize();

        $newEmbed = (new Embed)->hydrate($jsonSerialized);

        $this->assertEquals($embed->title(), $newEmbed->title());
        $this->assertEquals($embed->description(), $newEmbed->description());
        $this->assertEquals($embed->url(), $newEmbed->url());
        $this->assertEquals($embed->timestamp()->format(DateTime::ATOM), $newEmbed->timestamp()->format(DateTime::ATOM));
        $this->assertEquals($embed->color(), $newEmbed->color());
        $this->assertEquals($embed->footer()->text(), $newEmbed->footer()->text());
        $this->assertEquals($embed->imageUrl(), $newEmbed->imageUrl());
        $this->assertEquals($embed->thumbnailUrl(), $newEmbed->thumbnailUrl());
        $this->assertEquals($embed->author()->name(), $newEmbed->author()->name());
        $this->assertEquals($embed->fields()[0]->name(), $newEmbed->fields()[0]->name());
    }
}
