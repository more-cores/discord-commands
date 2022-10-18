<?php

namespace DiscordBuilder\Messages\Components\Types\Buttons;

use DiscordBuilder\Messages\Components\Types\SelectMenu\Option;
use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
    /** @test */
    public function canBeConstructedAndJsonified()
    {
        $label = 'asdf';
        $value = 'some-value';
        $option = new Option($label, $value);

        $this->assertEquals($label, $option->label());
        $this->assertEquals($value, $option->value());

        $json = $option->jsonSerialize();

        $this->assertArrayHasKey('label', $json);
        $this->assertEquals($option->label(), $json['label']);

        $this->assertArrayHasKey('value', $json);
        $this->assertEquals($option->value(), $json['value']);
    }
}
