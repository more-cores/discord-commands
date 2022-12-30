<?php

namespace DiscordCommands\Messages\Embed;

use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    private ?Field $field;

    public function setUp(): void
    {
        parent::setUp();

        $this->field = new Field('', '');
    }

    /** @test */
    public function canProvideName()
    {
        $this->assertEquals('', $this->field->name());

        $this->field->setName($name = uniqid());

        $this->assertEquals($name, $this->field->name());

        $this->assertArrayHasKey('name', $this->field->jsonSerialize());
        $this->assertEquals($name, $this->field->jsonSerialize()['name']);
    }

    /** @test */
    public function canProvideValue()
    {
        $this->field->setValue($value = uniqid());

        $this->assertEquals($value, $this->field->value());

        $this->assertArrayHasKey('value', $this->field->jsonSerialize());
        $this->assertEquals($value, $this->field->jsonSerialize()['value']);
    }

    /** @test */
    public function canProvideInline()
    {
        $this->assertFalse($this->field->isInline());

        $this->field->inline();

        $this->assertTrue($this->field->isInline());

        $this->assertArrayHasKey('inline', $this->field->jsonSerialize());
        $this->assertTrue($this->field->jsonSerialize()['inline']);
    }

    /** @test */
    public function convertsToAndFromArray()
    {
        $field = new Field(
            $name = uniqid(),
            $value = uniqid()
        );
        $field->setName($name = uniqid());
        $field->setValue($value = uniqid());
        $field->inline();

        $jsonSerialized = $field->jsonSerialize();

        $newField = (new Field())->hydrate($jsonSerialized);

        $this->assertEquals($field->name(), $newField->name());
        $this->assertEquals($field->value(), $newField->value());
        $this->assertTrue($newField->isInline());
    }
}
