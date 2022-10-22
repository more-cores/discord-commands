<?php

namespace DiscordBuilder\Commands\Interactions\ExecutionResults;

use DiscordBuilder\Hydrateable;

class CommandResultsOption implements Hydrateable
{
    protected string $name = '';
    protected int $type = 0;
    protected $value = null;
    protected array $options = [];
    protected ?bool $focused = null;

    public function name(): string
    {
        return $this->name;
    }

    public function type(): int
    {
        return $this->type;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function focused(): mixed
    {
        return $this->focused;
    }

    public function hasFocused(): bool
    {
        return $this->focused !== false;
    }

    public function options(): array
    {
        return $this->options;
    }

    public function hasOptions(): bool
    {
        return $this->options !== false;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['id'])) {
            $this->id = $array['id'];
        }

        if (isset($array['type'])) {
            $this->type = $array['type'];
        }

        if (isset($array['value'])) {
            $this->value = $array['value'];
        }

        if (isset($array['focused'])) {
            $this->focused = $array['focused'];
        }

        if (isset($array['options'])) {
            foreach ($array['options'] as $optionData) {
                $this->options[] = (new CommandResultsOption())
                    ->hydrate($optionData);
            }
        }

        return $this;
    }
}