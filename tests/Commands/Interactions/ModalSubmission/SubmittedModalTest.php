<?php

namespace Commands\Interactions\ModalSubmission;

use DiscordCommands\Commands\Interactions\ModalSubmission\SubmittedModal;
use DiscordCommands\Messages\Components\Types\ActionRow;
use DiscordCommands\Messages\Components\Types\TextInput\ShortInput;
use PHPUnit\Framework\TestCase;

class SubmittedModalTest extends TestCase
{
    /** @test */
    public function hydrates()
    {
        $modal = new SubmittedModal();

        $modalId = 'some-modal';
        $someFieldId = 'some-field';
        $someFieldValue = 'some-value';
        $someOtherFieldId = 'some-other-field';
        $someOtherFieldValue = 'some-other-value';
        $modal->hydrate([
            'custom_id' => $modalId,
            'components' => [
                [
                    'type' => ActionRow::TYPE,
                    'components' => [
                        [
                            'custom_id' => $someFieldId,
                            'type' =>  ShortInput::TYPE,
                            'value' => $someFieldValue,
                        ],
                    ],
                ],
                [
                    'type' => ActionRow::TYPE,
                    'components' => [
                        [
                            'custom_id' => $someOtherFieldId,
                            'type' =>  ShortInput::TYPE,
                            'value' => $someOtherFieldValue,
                        ],
                    ],
                ],
            ],
        ]);

        $this->assertEquals($modalId, $modal->id());
        $this->assertEquals($someFieldValue, $modal->fieldValue($someFieldId));
        $this->assertEquals($someOtherFieldValue, $modal->fieldValue($someOtherFieldId));
    }
}
