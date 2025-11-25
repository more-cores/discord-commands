<?php

namespace DiscordCommands\Commands\Options\Choices;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class NumberChoiceTest extends TestCase
{
    #[Test]
    public function serializesNameAndValue()
    {
        $name = 'my-name';
        $value = 12.56;
        $choice = new NumberChoice(
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
