<?php

namespace DiscordCommands\Commands\Interactions\Responding;

use DiscordCommands\Jsonable;

class Pong extends Jsonable implements CommandResponse
{
    public const TYPE = 1;

    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE,
        ];
    }
}