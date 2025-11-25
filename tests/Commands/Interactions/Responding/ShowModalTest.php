<?php

namespace DiscordCommands\Commands\Interactions\Responding;

use DiscordCommands\Messages\Components\Types\ActionRow;
use DiscordCommands\Messages\Components\Types\Buttons\PrimaryButton;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ShowModalTest extends TestCase
{
    #[Test]
    public function usesCustomIdField()
    {
        $modalId = '123';
        $response = new ShowModal(
            id: $modalId,
        );

        $json = $response->jsonSerialize();

        $this->assertArrayHasKey('custom_id', $json['data']);
        $this->assertEquals($modalId, $json['data']['custom_id']);
    }

    #[Test]
    public function offersActionRowShorthand()
    {
        $modal = new ShowModal();

        $this->assertFalse($modal->hasComponents());

        $compId = '34';
        $modal->actionRow(
            $component = new PrimaryButton($compId)
        );

        $this->assertTrue($modal->hasComponents());

        $this->assertInstanceOf(ActionRow::class, $modal->components()[0]);
        $this->assertEquals($component->id(), $modal->components()[0]->jsonSerialize()['components'][0]['custom_id']);

        $modal->jsonSerialize();
    }

    #[Test]
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
