<?php

namespace DiscordCommands\Commands\Options;

use DiscordCommands\Commands\Options\Types\SubCommandGroupOption;
use PHPUnit\Framework\TestCase;

class SubCommandGroupTest extends TestCase
{
    /** @test */
    public function serializesOptions()
    {
        $optionType = time();
        $option = new Option($optionType);
        $command = new SubCommandGroupOption();

        $this->assertFalse($command->hasOptions());

        $command->addOption($option);

        $this->assertTrue($command->hasOptions());

        $this->assertEquals($optionType, $command->options()[0]->type());

        $json = $command->jsonSerialize();

        $this->assertArrayHasKey('options', $json);
        $this->assertEquals($optionType, $json['options'][0]['type']);
    }
}
