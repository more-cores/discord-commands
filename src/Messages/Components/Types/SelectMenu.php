<?php

namespace DiscordCommands\Messages\Components\Types;

use DiscordCommands\Messages\Components\Component;

abstract class SelectMenu extends Component
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

    public function id(): string
    {
        return $this->id;
    }

    public function placeholder(): ?string
    {
        return $this->placeholder;
    }

    public function setPlaceholder(?string $placeholder = null): void
    {
        $this->placeholder = $placeholder;
    }

    public function minValues(): ?int
    {
        return $this->minValues;
    }

    public function setMinValues(?int $minValues = null): void
    {
        $this->minValues = $minValues;
    }

    public function maxValues(): ?int
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
            'custom_id' => $this->id(),
            'placeholder' => $this->placeholder(),
            'min_values' => $this->minValues(),
            'max_values' => $this->maxValues(),
        ];

        $data = array_filter(
            array_merge(
                parent::jsonSerialize(),
                $data,
            )
        );

        $data['disabled'] = $this->isDisabled();

        return $data;
    }
}
