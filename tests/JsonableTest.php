<?php

namespace DiscordBuilder;

use PHPUnit\Framework\TestCase;

class JsonableTest extends TestCase
{
    /** @test */
    public function canSerialize()
    {
        $jsonable = new JsonStub();

        $this->assertTrue(is_object(json_decode($jsonable->toJson())));
    }
}

class JsonStub extends Jsonable
{
    /**
     * Specify data which should be serialized to JSON.
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     *
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        return [
            'serializable' => true,
        ];
    }
}
