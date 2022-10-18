<?php

namespace DiscordBuilder\Messages\Components\Types\Buttons;

use DiscordBuilder\Messages\Components\Types\Button;

class LinkButton extends Button
{
    public const STYLE = 5;

    public function __construct(
        string $url,
        ?string $label = null,
        bool $disabled = false,
    ) {
        parent::__construct(
            style: self::STYLE,
            label: $label,
            url: $url,
            disabled: $disabled,
        );
    }
}
