<?php

namespace DiscordBuilder\Commands\Options\Choices;

use DiscordBuilder\Channel;
use DiscordBuilder\Commands\Options\Choices\StringChoice;
use DiscordBuilder\Commands\Options\Types\ChannelOption;
use PHPUnit\Framework\TestCase;

class StringChoiceTest extends TestCase
{
    /** @test */
    public function serializesNameAndValue()
    {
        $name = 'my-name';
        $value = 'my-value';
        $choice = new StringChoice(
            name: $name,
            value: $value,
        );

        $this->assertEquals($name, $choice->name());
        $this->assertEquals($value, $choice->value());

        $json = $choice->jsonSerialize();

        $this->assertArrayHasKey('name', $json);
        $this->assertEquals($name, $json['name']);
        $this->assertArrayHasKey('value', $json);
        $this->assertEquals($value, $json['value']);
    }
}
