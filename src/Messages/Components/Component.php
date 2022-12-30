<?php

namespace DiscordCommands\Messages\Components;

use DiscordCommands\Jsonable;

class Component extends Jsonable
{
    public function __construct(
        protected int $type
    ) { }

    public function type(): int
    {
        return $this->type;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type(),
        ];
    }
}
