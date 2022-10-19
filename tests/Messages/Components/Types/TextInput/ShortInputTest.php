<?php

namespace DiscordBuilder\Messages\Components\Types\TextInput;

use PHPUnit\Framework\TestCase;

class ShortInputTest extends TestCase
{
    /** @test */
    public function canBeConstructedAndJsonified()
    {
        $id = '4';
        $label = 'my-field';
        $input = new ShortInput($id, $label);

        $this->assertEquals(1, $input->style());
        $this->assertEquals($label, $input->label());

        $json = $input->jsonSerialize();

        $this->assertArrayHasKey('label', $json);
        $this->assertEquals($input->label(), $json['label']);
    }
}
