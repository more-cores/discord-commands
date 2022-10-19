<?php

namespace DiscordBuilder\Commands\Options\Choices;

class StringChoice extends Choice
{
    public function __construct(
        protected string $name,
        protected string $value,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->value;
    }
}
