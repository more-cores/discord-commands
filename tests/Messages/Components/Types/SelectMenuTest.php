<?php

namespace DiscordCommands\Messages\Components\Types;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class SelectMenuTest extends TestCase
{
    #[Test]
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

    #[Test]
    public function canProvideDefaultValues()
    {
        $selectMenu = new class(5, 'asdf') extends SelectMenu {
        };

        $this->assertFalse($selectMenu->hasDefaultValues());
        $this->assertArrayNotHasKey('default_values', $selectMenu->jsonSerialize());

        $selectMenu->addDefaultUser('111');
        $selectMenu->addDefaultRole('222');
        $selectMenu->addDefaultChannel('333');

        $this->assertTrue($selectMenu->hasDefaultValues());

        $json = $selectMenu->jsonSerialize();

        $this->assertArrayHasKey('default_values', $json);
        $this->assertEquals([
            ['id' => '111', 'type' => 'user'],
            ['id' => '222', 'type' => 'role'],
            ['id' => '333', 'type' => 'channel'],
        ], $json['default_values']);
    }
}
