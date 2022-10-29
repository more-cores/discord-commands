<?php

namespace DiscordBuilder\Commands\Interactions\Responding;

use DiscordBuilder\Commands\Options\Choices\BooleanChoice;
use PHPUnit\Framework\TestCase;

class ProvideAutocompleteOptionsTest extends TestCase
{
    /** @test */
    public function verifyUsesChoices()
    {
        $response = new ProvideAutocompleteOptions();

        $this->assertFalse($response->hasChoices());

        $name = 'something';
        $value = 'else';
        $component = new BooleanChoice(
            $name,
            $value,
        );

        $response->addChoice($component);

        $this->assertTrue($response->hasChoices());

        $this->assertEquals($name, $response->choices()[0]->name());

        $json = $response->jsonSerialize();

        $this->assertArrayHasKey('choices', $json['data']);
        $this->assertEquals($name, $json['data']['choices'][0]['name']);
    }
}
