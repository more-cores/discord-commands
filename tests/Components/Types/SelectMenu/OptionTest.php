<?php

namespace DiscordBuilder\Components\Types\Buttons;

use DiscordBuilder\Components\Types\SelectMenu\Option;
use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
    /** @test */
    public function canBeConstructedAndJsonified()
    {
        $label = 'asdf';
        $value = 'some-value';
        $option = new Option($label, $value);

        $this->assertEquals($label, $option->getLabel());
        $this->assertEquals($value, $option->getValue());

        $json = $option->jsonSerialize();

        $this->assertArrayHasKey('label', $json);
        $this->assertEquals($option->getLabel(), $json['label']);

        $this->assertArrayHasKey('value', $json);
        $this->assertEquals($option->getValue(), $json['value']);
    }
}
