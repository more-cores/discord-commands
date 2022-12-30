<?php

namespace DiscordCommands\Messages\Components\Types\Buttons;

use DiscordCommands\Messages\Components\Types\Button;
use DiscordCommands\PartialEmoji;

class DangerButton extends Button
{
    public const STYLE = 4;

    public function __construct(
        string $id,
        ?string $label = null,
        ?PartialEmoji $emoji = null,
        bool $disabled = false,
    ) {
        parent::__construct(
            style: self::STYLE,
            label: $label,
            id: $id,
            emoji: $emoji,
            disabled: $disabled,
        );
    }
}
