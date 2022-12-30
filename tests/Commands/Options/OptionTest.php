<?php

namespace DiscordCommands\Commands\Options;

use DiscordCommands\Commands\HasCommandOptions;
use DiscordCommands\Commands\Options\Choices\StringChoice;
use PHPUnit\Framework\TestCase;

class OptionTest extends TestCase
{
    /** @test */
    public function verifySerializes()
    {
        $type = time();
        $option = new Option($type);

        $json = $option->jsonSerialize();

        $this->assertArrayHasKey('type', $json);
        $this->assertEquals($type, $json['type']);
    }

    /** @test */
    public function serializesOptions()
    {
        $optionType = time();
        $otherOption = new Option($otherOptionType = '12848');
        $option = new class($optionType) extends Option {
            use HasCommandOptions;
        };

        $this->assertFalse($option->hasOptions());

        $option->addOption($otherOption);
        $this->assertTrue($option->hasOptions());
        $this->assertEquals($otherOptionType, $option->options()[0]->type());

        $json = $option->jsonSerialize();

        $this->assertArrayHasKey('options', $json);
        $this->assertEquals($otherOptionType, $json['options'][0]['type']);
    }

    /** @test */
    public function serializesChoices()
    {
        $otherOption = new StringChoice(
            name: $name = 'name1',
            value: $value = 'value1',
        );
        $option = new class(time()) extends Option {
            use HasOptionChoices;
        };

        $this->assertFalse($option->hasChoices());
        $option->addChoice($otherOption);
        $this->assertTrue($option->hasChoices());

        $json = $option->jsonSerialize();

        $this->assertArrayHasKey('choices', $json);
        $this->assertEquals($name, $json['choices'][0]['name']);
        $this->assertEquals($value, $json['choices'][0]['value']);
    }

    /** @test */
    public function serializesAutocomplete()
    {
        $option = new class(time()) extends Option {
            use HasAutocomplete;
        };

        $this->assertFalse($option->isAutocompleteEnabled());
        $option->setAutocomplete(true);
        $this->assertTrue($option->isAutocompleteEnabled());

        $json = $option->jsonSerialize();

        $this->assertArrayHasKey('autocomplete', $json);
        $this->assertTrue($json['autocomplete']);
    }

    /** @test */
    public function serializesMinAndMaxLength()
    {
        $minLength = 12;
        $maxLength = 120;
        $option = new class(time()) extends Option {
            use HasMinAndMaxLength;
        };

        $this->assertFalse($option->hasMinLength());
        $option->setMinLength($minLength);
        $this->assertTrue($option->hasMinLength());

        $this->assertFalse($option->hasMaxLength());
        $option->setMaxLength($maxLength);
        $this->assertTrue($option->hasMaxLength());

        $json = $option->jsonSerialize();

        $this->assertArrayHasKey('min_length', $json);
        $this->assertEquals($minLength, $json['min_length']);
        $this->assertArrayHasKey('max_length', $json);
        $this->assertEquals($maxLength, $json['max_length']);
    }

    /** @test */
    public function serializesMinAndMaxValues()
    {
        $minValue = 12;
        $maxValue = 120;
        $option = new class(time()) extends Option {
            use HasMinAndMaxValues;
        };

        $this->assertFalse($option->hasMinValue());
        $option->setMinValue($minValue);
        $this->assertTrue($option->hasMinValue());

        $this->assertFalse($option->hasMaxValue());
        $option->setMaxValue($maxValue);
        $this->assertTrue($option->hasMaxValue());

        $json = $option->jsonSerialize();

        $this->assertArrayHasKey('min_value', $json);
        $this->assertEquals($minValue, $json['min_value']);
        $this->assertArrayHasKey('max_value', $json);
        $this->assertEquals($maxValue, $json['max_value']);
    }
}
