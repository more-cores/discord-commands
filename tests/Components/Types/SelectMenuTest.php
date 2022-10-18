<?php

namespace DiscordBuilder\Components\Types;

use PHPUnit\Framework\TestCase;

class SelectMenuTest extends TestCase
{
    /** @test */
    public function canBeConstructedAndJsonified()
    {
        $id = 'asdf';
        $selectMenu = new SelectMenu(1, $id);

        $this->assertEquals($id, $selectMenu->id());

        $json = $selectMenu->jsonSerialize();

        $this->assertArrayHasKey('custom_id', $json);
        $this->assertEquals($selectMenu->id(), $json['custom_id']);
    }
}
