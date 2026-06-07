<?php

namespace DiscordCommands\Commands\Interactions\Responding;

use DiscordCommands\Jsonable;

/**
 * Acknowledges a component interaction without immediately editing the message.
 * The message can be edited later.  Nothing is shown to the user in the
 * meantime.
 */
class DeferUpdate extends Jsonable implements CommandResponse
{
    public const TYPE = 6;

    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE,
        ];
    }
}
