<?php

namespace DiscordBuilder\Commands\Options\Choices;

class IntegerChoice extends Choice
{
    public function __construct(
        protected string $name,
        protected int $value,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function value(): int
    {
        return $this->value;
    }
}
