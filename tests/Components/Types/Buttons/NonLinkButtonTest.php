<?php

namespace DiscordBuilder\Components\Types\Buttons;

use PHPUnit\Framework\TestCase;

class NonLinkButtonTest extends TestCase
{

    /**
     * @test
     * @dataProvider nonLinkButtonTypes
     */
    public function canBeConstructedAndJsonified(string $buttonClass)
    {
        $id = 'asdf';
        $button = new $buttonClass($id);

        $this->assertEquals($id, $button->id());

        $json = $button->jsonSerialize();
        $this->assertArrayHasKey('custom_id', $json);
        $this->assertEquals($button->id(), $json['custom_id']);
    }

    public static function nonLinkButtonTypes()
    {
        return [
            [PrimaryButton::class],
            [SecondaryButton::class],
            [SuccessButton::class],
            [DangerButton::class],
        ];
    }
}
