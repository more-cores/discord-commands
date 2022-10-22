<?php

namespace DiscordBuilder\Commands\Interactions\Responding;

use DiscordBuilder\Jsonable;

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