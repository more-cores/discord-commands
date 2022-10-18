<?php

namespace DiscordBuilder\Components\Types\SelectMenu;

use DiscordBuilder\Components\Types\SelectMenu;

class MentionableSelectMenu extends SelectMenu
{
    public const TYPE = 7;

    public function __construct(
        string $id,
    ) {
        parent::__construct(
            type: self::TYPE,
            id: $id
        );
    }
}