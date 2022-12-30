<?php

namespace DiscordCommands\Commands\Options;

trait HasMinAndMaxValues
{
    protected ?int $minValue = null;
    protected ?int $maxValue = null;

    public function minValue(): int
    {
        return $this->minValue;
    }

    public function setMinValue(?int $minValue = null): void
    {
        $this->minValue = $minValue;
    }

    public function hasMinValue(): bool
    {
        return $this->minValue !== null;
    }

    public function maxValue(): int
    {
        return $this->maxValue;
    }

    public function setMaxValue(?int $maxValue = null): void
    {
        $this->maxValue = $maxValue;
    }

    public function hasMaxValue(): bool
    {
        return $this->maxValue !== null;
    }
}