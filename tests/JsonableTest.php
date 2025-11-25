<?php

namespace DiscordCommands;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class JsonableTest extends TestCase
{
    #[Test]
    public function canSerialize()
    {
        $jsonable = new JsonStub();

        $this->assertTrue(is_object(json_decode($jsonable->toJson())));
    }
}

class JsonStub extends Jsonable
{
    public function jsonSerialize(): array
    {
        return [
            'serializable' => true,
        ];
    }
}
