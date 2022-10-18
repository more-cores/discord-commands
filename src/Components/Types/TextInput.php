<?php

namespace DiscordBuilder\Components\Types;

use DiscordBuilder\Components\Component;

class TextInput extends Component
{
    public const TYPE = 4;

    protected ?string $label;
    protected ?int $minLength;
    protected ?int $maxLength;
    protected bool $required = false;
    protected ?string $value;
    protected ?string $placeholder;

    public function __construct(
        protected int $style,
        protected string $id,
        ?string $label = null,
        ?int $minLength = null,
        ?int $maxLength = null,
        bool $required = false,
        ?string $value = null,
        ?string $placeholder = null,
    ) {
        parent::__construct(self::TYPE);

        $this->label = $label;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
        $this->required = $required;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStyle(): int
    {
        return $this->style;
    }

    public function setStyle(int $style): void
    {
        $this->style = $style;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function setLabel(?string $label = null): void
    {
        $this->label = $label;
    }

    public function hasLabel(): bool
    {
        return $this->label !== null;
    }

    public function minLength(): int
    {
        return $this->minLength;
    }

    public function setMinLength(?int $minLength = null): void
    {
        $this->minLength = $minLength;
    }

    public function hasMinLength(): bool
    {
        return $this->minLength !== null;
    }

    public function maxLength(): int
    {
        return $this->maxLength;
    }

    public function setMaxLength(?int $maxLength = null): void
    {
        $this->maxLength = $maxLength;
    }

    public function hasMaxLength(): bool
    {
        return $this->maxLength !== null;
    }

    public function isRequired(): bool
    {
        return $this->required === true;
    }

    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function setValue(?string $value = null): void
    {
        $this->value = $value;
    }

    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function placeholder(): string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(?string $placeholder = null): void
    {
        $this->placeholder = $placeholder;
    }

    public function hasPlaceholder(): bool
    {
        return $this->placeholder !== null;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'custom_id' => $this->id,
            'style' => $this->style,
            'required' => $this->required,
        ];

        if ($this->hasLabel()) {
            $data['label'] = $this->label();
        }

        if ($this->hasMinLength()) {
            $data['min_Length'] = $this->minLength();
        }

        if ($this->hasMaxLength()) {
            $data['max_Length'] = $this->maxLength();
        }

        if ($this->hasValue()) {
            $data['value'] = $this->value();
        }

        if ($this->hasPlaceholder()) {
            $data['placeholder'] = $this->placeholder();
        }

        return array_filter(
            array_merge(
                parent::jsonSerialize(),
                $data,
            )
        );
    }
}
