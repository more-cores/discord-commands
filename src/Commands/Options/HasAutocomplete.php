<?php

namespace DiscordBuilder\Commands\Options;

trait HasAutocomplete
{
    protected ?bool $autocomplete = null;

    public function isAutocompleteEnabled(): bool
    {
        return $this->autocomplete === true;
    }

    public function setAutocomplete(bool $autocomplete): void
    {
        $this->autocomplete = $autocomplete;
    }
}