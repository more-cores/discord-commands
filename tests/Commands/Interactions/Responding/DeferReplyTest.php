<?php

namespace DiscordCommands\Commands\Interactions\Responding\Responses;

use DiscordCommands\Commands\Interactions\Responding\DeferReply;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DeferReplyTest extends TestCase
{
    #[Test]
    public function serializes()
    {
        $json = (new DeferReply())->jsonSerialize();

        $this->assertEquals(DeferReply::TYPE, $json['type']);
        $this->assertEquals(5, $json['type']);
        $this->assertArrayNotHasKey('data', $json);
    }

    #[Test]
    public function canBeEphemeral()
    {
        $json = (new DeferReply(onlyVisibleToCommandIssuer: true))->jsonSerialize();

        $this->assertArrayHasKey('flags', $json['data']);

        if (!(DeferReply::FLAG_EPHEMERAL & $json['data']['flags'])) {
            $this->assertTrue(false, 'ephemeral bitwise operator not applied');
        }
    }
}
