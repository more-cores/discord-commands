<?php

namespace DiscordBuilder\Messages\Components\Types\Buttons;

use DiscordBuilder\Messages\Components\Types\Button;
use DiscordBuilder\Messages\PartialEmoji;

class SuccessButton extends Button
{
    public const STYLE = 3;

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
