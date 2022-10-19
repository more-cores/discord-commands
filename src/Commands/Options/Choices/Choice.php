<?php

namespace DiscordBuilder\Commands\Options\Choices;

use DiscordBuilder\Jsonable;

abstract class Choice extends Jsonable
{
    abstract public function name(): string;

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name(),
            'value' => $this->value(),
        ];
    }
}
