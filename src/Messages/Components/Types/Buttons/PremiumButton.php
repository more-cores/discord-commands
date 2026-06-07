<?php

namespace DiscordCommands\Messages\Components\Types\Buttons;

use DiscordCommands\Messages\Components\Types\Button;

/**
 * A premium button links to a purchasable SKU.  Unlike other buttons it has no
 * label, custom_id, or emoji - Discord renders it using the SKU's details.
 */
class PremiumButton extends Button
{
    public const STYLE = 6;

    public function __construct(
        string $skuId,
        bool $disabled = false,
    ) {
        parent::__construct(
            style: self::STYLE,
            disabled: $disabled,
            skuId: $skuId,
        );
    }
}
