<?php

namespace DiscordBuilder\Commands;

use DiscordBuilder\Commands\Options\Option;

trait HasCommandOptions
{
    protected array $options = [];

    public function hasOptions(): bool
    {
        return count($this->options) > 0;
    }

    /**
     * @return Option[]
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * @param Option[] $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function addOption(Option $option): void
    {
        $this->options[] = $option;
    }
}