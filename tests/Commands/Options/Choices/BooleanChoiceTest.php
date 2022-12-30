<?php

namespace DiscordCommands\Commands\Options\Choices;

use PHPUnit\Framework\TestCase;

class BooleanChoiceTest extends TestCase
{
    /** @test */
    public function serializesNameAndValue()
    {
        $name = 'my-name';
        $value = false;
        $choice = new BooleanChoice(
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
