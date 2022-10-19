<?php

namespace DiscordBuilder\Commands\Options\Choices;

class NumberChoice extends Choice
{
    public function __construct(
        protected string $name,
        protected float $value,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function value(): float
    {
        return $this->value;
    }
}
