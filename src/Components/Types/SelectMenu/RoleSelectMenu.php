<?php

namespace DiscordBuilder\Components\Types\SelectMenu;

use DiscordBuilder\Components\Types\SelectMenu;

class RoleSelectMenu extends SelectMenu
{
    public const TYPE = 6;

    public function __construct(
        string $id,
    ) {
        parent::__construct(
            type: self::TYPE,
            id: $id
        );
    }
}