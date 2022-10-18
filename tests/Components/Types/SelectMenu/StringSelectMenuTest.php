<?php

namespace DiscordBuilder\Components\Types\SelectMenu;

use PHPUnit\Framework\TestCase;

class StringSelectMenuTest extends TestCase
{
    /** @test */
    public function canAddOptions()
    {
        $option1 = new class('label', 'value') extends Option {

        };
        $id = 'asdf';
        $selectMenu = new StringSelectMenu(
            id: $id,
            options: [$option1]
        );

        $this->assertEquals($id, $selectMenu->getId());
        $this->assertEquals($option1, $selectMenu->getOptions()[0]);

        $json = $selectMenu->jsonSerialize();

        $this->assertArrayHasKey('custom_id', $json);
        $this->assertEquals($selectMenu->getId(), $json['custom_id']);

        $this->assertArrayHasKey('options', $json);
        $this->assertEquals($option1->getLabel(), $json['options'][0]['label']);
        $this->assertEquals($option1->getValue(), $json['options'][0]['value']);
    }

    /** @test */
    public function canMakeOptionDefault()
    {
        $option1 = new class('label', 'value') extends Option {

        };
        $selectMenu = new StringSelectMenu(
            id: 'id',
            options: [$option1],
        );

        $this->assertFalse($selectMenu->getOptions()[0]->isDefault());

        $selectMenu->makeDefault($option1->getLabel());

        $this->assertTrue($selectMenu->getOptions()[0]->isDefault());
    }
}
