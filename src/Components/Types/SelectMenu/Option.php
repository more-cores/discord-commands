<?php

namespace DiscordBuilder\Components\Types\SelectMenu;

use DiscordBuilder\PartialEmoji;

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

    public function setLabel(string $label)
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setValue(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
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
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
            'default' => $this->isDefault(),
        ];

        if ($this->hasDescription()) {
            $data['description'] = $this->getDescription();
        }

        if ($this->emoji instanceof PartialEmoji) {
            $data['emoji'] = $this->emoji->jsonSerialize();
        }

        return array_filter($data);
    }
}
