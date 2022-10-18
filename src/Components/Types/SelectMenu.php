<?php

namespace DiscordBuilder\Components\Types;

use DiscordBuilder\Components\Component;

class SelectMenu extends Component
{
    protected ?string $placeholder;
    protected ?int $minValues;
    protected ?int $maxValues;

    public function __construct(
        protected int $type,
        protected string $id,
        ?string $placeholder = null,
        ?int $minValues = null,
        ?int $maxValues = null,
        protected bool $disabled = false,
    ) {
        parent::__construct(
            type: $type,
        );

        $this->placeholder = $placeholder;
        $this->minValues = $minValues;
        $this->maxValues = $maxValues;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(?string $placeholder = null): void
    {
        $this->placeholder = $placeholder;
    }

    public function getMinValues(): ?int
    {
        return $this->minValues;
    }

    public function setMinValues(?int $minValues = null): void
    {
        $this->minValues = $minValues;
    }

    public function getMaxValues(): ?int
    {
        return $this->maxValues;
    }

    public function setMaxValues(?int $maxValues = null): void
    {
        $this->maxValues = $maxValues;
    }

    public function isEnabled(): bool
    {
        return $this->disabled === false;
    }

    public function isDisabled(): bool
    {
        return $this->disabled === true;
    }

    public function setDisabled(bool $disabled): void
    {
        $this->disabled = $disabled;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'custom_id' => $this->getId(),
            'placeholder' => $this->getPlaceholder(),
            'min_values' => $this->getMinValues(),
            'max_values' => $this->getMaxValues(),
            'disabled' => $this->isDisabled(),
        ];

        return array_filter(
            array_merge(
                parent::jsonSerialize(),
                $data,
            )
        );
    }
}
