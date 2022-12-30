<?php

namespace DiscordCommands\Messages\Embed;

use DiscordCommands\Hydrateable;
use DiscordCommands\Jsonable;

class Field extends Jsonable implements Hydrateable
{
    protected ?string $name;
    protected ?string $value;
    protected bool $inline = false;

    public function __construct(
        ?string $name = null,
        ?string $value = null,
        bool $inline = false,
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->inline = $inline;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function hasName(): bool
    {
        return $this->name != null;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function hasValue(): bool
    {
        return $this->value != null;
    }

    public function inline(): void
    {
        $this->inline = true;
    }

    public function isInline(): bool
    {
        return $this->inline;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }

        if (isset($array['value'])) {
            $this->setValue($array['value']);
        }

        if (isset($array['inline']) && $array['inline']) {
            $this->inline();
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->hasName()) {
            $data['name'] = $this->name();
        }

        if ($this->hasValue()) {
            $data['value'] = $this->value();
        }

        if ($this->isInline()) {
            $data['inline'] = true;
        }

        return $data;
    }
}
