<?php

namespace DiscordBuilder\Commands\Interactions\Data;

use DiscordBuilder\Commands\Interactions\ApplicationCommandDataOption;

trait HasApplicationCommandData
{
    protected array $data = [];

    public function hasData(): bool
    {
        return count($this->data) > 0;
    }

    /**
     * @return ApplicationCommandDataOption[]
     */
    public function data(): array
    {
        return $this->data;
    }
}