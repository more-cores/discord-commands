<?php

namespace DiscordCommands\Messages\Components\Types\TextInput;

use PHPUnit\Framework\TestCase;

class ShortInputTest extends TestCase
{
    /** @test */
    public function requirementCanBeDisabled()
    {
        $id = '4';
        $label = 'my-field';
        $input = new ShortInput(
            $id,
            $label,
            required: false,
        );

        $this->assertEquals(1, $input->style());
        $this->assertEquals($label, $input->label());

        $json = $input->jsonSerialize();

        $this->assertArrayHasKey('required', $json);
        $this->assertFalse($json['required']);
    }

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

        $this->assertArrayHasKey('required', $json);
        $this->assertEquals($input->isRequired(), $json['required']);
    }
}
