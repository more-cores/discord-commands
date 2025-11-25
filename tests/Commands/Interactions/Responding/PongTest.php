<?php

namespace DiscordCommands\Commands\Interactions\Responding;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PongTest extends TestCase
{
    #[Test]
    public function serializes()
    {
        $pong = new Pong();

        $json = $pong->jsonSerialize();

        $this->assertArrayHasKey('type', $json);
        $this->assertEquals(Pong::TYPE, $json['type']);
    }
}
