<?php

namespace DiscordCommands\Messages\Components\Types\SelectMenu;

use DiscordCommands\Messages\Components\Types\SelectMenu;

class UserSelectMenu extends SelectMenu
{
    public const TYPE = 5;

    public function __construct(
        string $id,
    ) {
        parent::__construct(
            type: self::TYPE,
            id: $id
        );
    }
}