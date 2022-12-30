<?php

namespace DiscordCommands\Messages\Components;

trait HasComponents
{
    protected array $components = [];

    public function addComponent(Component $component): void
    {
        $this->components[] = $component;
    }

    public function setComponents(array $components): void
    {
        $this->components = $components;
    }

    /**
     * @return Component[]
     */
    public function components(): array
    {
        return $this->components;
    }

    public function hasComponents(): bool
    {
        return count($this->components) > 0;
    }

    protected function serializeComponents(): array
    {
        $components = [];
        if ($this->hasComponents()) {
            foreach ($this->components() as $component) {
                $components[] = $component->jsonSerialize();
            }
        }

        return $components;
    }
}