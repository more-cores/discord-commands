<?php

namespace DiscordBuilder\Messages\Components\Types\SelectMenu;

use DiscordBuilder\Messages\PartialEmoji;

class Option
{
    protected ?string $description;
    protected ?PartialEmoji $emoji;
    protected bool $default = false;

    public function __construct(
        protected string $label,
        protected string $value,
        ?string $description = null,
        ?PartialEmoji $emoji = null,
        bool $default = false,
    ) {
        $this->description = $description;
        $this->emoji = $emoji;
        $this->default = $default;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function hasDescription(): bool
    {
        return $this->description !== null;
    }

    public function isDefault(): bool
    {
        return $this->default === true;
    }

    public function setDefault(bool $default): void
    {
        $this->default = $default;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'label' => $this->label(),
            'value' => $this->value(),
            'default' => $this->isDefault(),
        ];

        if ($this->hasDescription()) {
            $data['description'] = $this->description();
        }

        if ($this->emoji instanceof PartialEmoji) {
            $data['emoji'] = $this->emoji->jsonSerialize();
        }

        return array_filter($data);
    }
}
