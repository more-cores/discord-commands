<?php

namespace DiscordCommands\Commands\Interactions\Responding\Responses;

use DiscordCommands\Commands\Interactions\Responding\DeferUpdate;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DeferUpdateTest extends TestCase
{
    #[Test]
    public function serializes()
    {
        $json = (new DeferUpdate())->jsonSerialize();

        $this->assertEquals(DeferUpdate::TYPE, $json['type']);
        $this->assertEquals(6, $json['type']);
    }
}
