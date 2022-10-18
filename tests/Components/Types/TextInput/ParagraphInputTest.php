<?php

namespace DiscordBuilder\Components\Types\TextInput;

use DiscordBuilder\Components\Types\SelectMenu\Option;
use PHPUnit\Framework\TestCase;

class ParagraphInputTest extends TestCase
{
    /** @test */
    public function canBeConstructedAndJsonified()
    {
        $id = '4';
        $label = 'my-field';
        $input = new ParagraphInput($id, $label);

        $this->assertEquals(2, $input->getStyle());
        $this->assertEquals($label, $input->label());

        $json = $input->jsonSerialize();

        $this->assertArrayHasKey('label', $json);
        $this->assertEquals($input->label(), $json['label']);
    }
}
