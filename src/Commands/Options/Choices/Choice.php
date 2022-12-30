<?php

namespace DiscordCommands\Commands\Options\Choices;

use DiscordCommands\Jsonable;

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
