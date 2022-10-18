<?php

namespace DiscordBuilder\Components\Types\SelectMenu;

use DiscordBuilder\Components\Types\SelectMenu;

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