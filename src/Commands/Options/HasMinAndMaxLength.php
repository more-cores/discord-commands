<?php

namespace DiscordCommands\Commands\Options;

trait HasMinAndMaxLength
{
    protected ?int $minLength = null;
    protected ?int $maxLength = null;

    public function minLength(): int
    {
        return $this->minLength;
    }

    public function setMinLength(?int $minLength = null): void
    {
        $this->minLength = $minLength;
    }

    public function hasMinLength(): bool
    {
        return $this->minLength !== null;
    }

    public function maxLength(): int
    {
        return $this->maxLength;
    }

    public function setMaxLength(?int $maxLength = null): void
    {
        $this->maxLength = $maxLength;
    }

    public function hasMaxLength(): bool
    {
        return $this->maxLength !== null;
    }
}