<?php

namespace DiscordBuilder\Commands\Interactions\Data;

trait HasApplicationCommandData
{
    protected ?ApplicationCommandData $data = null;

    public function hasData(): bool
    {
        return $this->data !== null;
    }

    public function data(): ApplicationCommandData
    {
        return $this->data;
    }

    public function hydrateApplicationCommandData(array $data): void
    {
        $this->data = (new ApplicationCommandData())->hydrate($data);
    }
}