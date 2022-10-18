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

        $this->assertEquals($id, $selectMenu->getId());

        $json = $selectMenu->jsonSerialize();

        $this->assertArrayHasKey('custom_id', $json);
        $this->assertEquals($selectMenu->getId(), $json['custom_id']);
    }
}
