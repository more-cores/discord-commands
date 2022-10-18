<?php

namespace DiscordBuilder\Commands;

use DiscordBuilder\Jsonable;

class Option extends Jsonable
{
    public function jsonSerialize(): array
    {
        return [];
    }
}
