<?php

namespace DiscordBuilder\Commands\Interactions\Responding;

use DiscordBuilder\Messages\Components\Types\Buttons\PrimaryButton;
use PHPUnit\Framework\TestCase;

class ShowModalTest extends TestCase
{
    /** @test */
    public function verifyUsesComponents()
    {
        $response = new ShowModal();

        $this->assertFalse($response->hasComponents());

        $compId = '34';
        $component = new PrimaryButton($compId);

        $response->addComponent($component);

        $this->assertTrue($response->hasComponents());

        $this->assertEquals($compId, $response->components()[0]->id());

        $json = $response->jsonSerialize();

        $this->assertArrayHasKey('components', $json['data']);
        $this->assertEquals($compId, $json['data']['components'][0]['custom_id']);
    }
}
