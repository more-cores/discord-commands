<?php

namespace DiscordCommands\Commands\Options\Choices;

class BooleanChoice extends Choice
{
    public function __construct(
        protected string $name,
        protected bool $value,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function value(): bool
    {
        return $this->value;
    }
}
