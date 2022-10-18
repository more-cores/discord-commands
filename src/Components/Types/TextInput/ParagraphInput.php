<?php

namespace DiscordBuilder\Components\Types\TextInput;

use DiscordBuilder\Components\Types\TextInput;

class ParagraphInput extends TextInput
{
    public const STYLE = 2;

    public function __construct(
        string $id,
        string $label,
        ?int $minLength = null,
        ?int $maxLength = null,
        bool $required = false,
        ?string $value = null,
        ?string $placeholder = null,
    ) {
        parent::__construct(
            style: self::STYLE,
            id: $id,
            label: $label,
            minLength: $minLength,
            maxLength: $maxLength,
            required: $required,
            value: $value,
            placeholder: $placeholder,
        );
    }
}
