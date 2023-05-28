<?php

namespace DiscordCommands\Commands\Interactions\ModalSubmission;

use DiscordCommands\Hydrateable;

class SubmittedModal implements Hydrateable
{
    protected ?string $id = null;
    protected array $submittedData = [];

    public function id(): string
    {
        return $this->id;
    }

    public function fieldHasValue(string $field): bool
    {
        return isset($this->submittedData[$field]) &&
            $this->submittedData[$field] !== null;
    }

    public function fieldValue(string $field): ?string
    {
        return $this->submittedData[$field];
    }

    public function hydrate(array $array): self
    {
        if (isset($array['custom_id'])) {
            $this->id = $array['custom_id'];
        }

        if (isset($array['components']) && count($array['components']) > 0) {
            foreach ($array['components'] as $actionRow) {
                foreach ($actionRow['components'] as $component) {
                    $this->submittedData[$component['custom_id']] = $component['value'];
                }
            }
        }

        return $this;
    }
}