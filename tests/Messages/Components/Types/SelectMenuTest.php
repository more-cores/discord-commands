<?php

namespace DiscordCommands\Messages\Components\Types;

use PHPUnit\Framework\TestCase;

class SelectMenuTest extends TestCase
{
    /** @test */
    public function canBeConstructedAndJsonified()
    {
        $id = 'asdf';
        $selectMenu = new class(1, $id) extends SelectMenu {

        };

        $this->assertEquals($id, $selectMenu->id());

        $json = $selectMenu->jsonSerialize();

        $this->assertArrayHasKey('custom_id', $json);
        $this->assertEquals($selectMenu->id(), $json['custom_id']);
    }
}
