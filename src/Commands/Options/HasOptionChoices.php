<?php

namespace DiscordBuilder\Commands\Options;

use DiscordBuilder\Commands\Options\Choices\Choice;

trait HasOptionChoices
{
    protected array $choices = [];

    public function hasChoices(): bool
    {
        return count($this->choices) > 0;
    }

    /**
     * @@return Choice[]
     */
    public function choices(): array
    {
        return $this->choices;
    }

    /**
     * @param Choice[] $choices
     */
    public function setChoices(array $choices): void
    {
        $this->choices = $choices;
    }

    public function addChoice(Choice $choices): void
    {
        $this->choices[] = $choices;
    }

    protected function serializeChoices(): array
    {
        $choices = [];
        if ($this->hasChoices()) {
            foreach ($this->choices() as $choice) {
                $choices[] = $choice->jsonSerialize();
            }
        }

        return $choices;
    }
}