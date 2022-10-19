<?php

namespace DiscordBuilder\Commands\Options\Choices;

use PHPUnit\Framework\TestCase;

class IntegerChoiceTest extends TestCase
{
    /** @test */
    public function serializesNameAndValue()
    {
        $name = 'my-name';
        $value = time();
        $choice = new IntegerChoice(
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
