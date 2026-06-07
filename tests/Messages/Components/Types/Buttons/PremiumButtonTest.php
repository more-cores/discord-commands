<?php

namespace DiscordCommands\Messages\Components\Types\Buttons;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PremiumButtonTest extends TestCase
{
    #[Test]
    public function canBeConstructedAndJsonified()
    {
        $skuId = '1234567890';
        $button = new PremiumButton($skuId);

        $this->assertEquals($skuId, $button->skuId());

        $json = $button->jsonSerialize();

        $this->assertEquals(PremiumButton::STYLE, $json['style']);
        $this->assertEquals(6, $json['style']);
        $this->assertArrayHasKey('sku_id', $json);
        $this->assertEquals($skuId, $json['sku_id']);

        // premium buttons carry no label or custom_id
        $this->assertArrayNotHasKey('label', $json);
        $this->assertArrayNotHasKey('custom_id', $json);
    }
}
