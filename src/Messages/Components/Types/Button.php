<?php

namespace DiscordBuilder\Messages\Components\Types;

use DiscordBuilder\Messages\Components\Component;
use DiscordBuilder\Messages\PartialEmoji;

class Button extends Component
{
    public const TYPE = 2;

    protected ?string $label = null;
    protected ?string $id = null;
    protected ?string $url = null;
    protected ?PartialEmoji $emoji = null;
    protected bool $disabled = false;

    public function __construct(
        protected int $style,
        ?string $label = null,
        ?string $id = null,
        ?string $url = null,
        ?PartialEmoji $emoji = null,
        bool $disabled = false,
    ) {
        parent::__construct(self::TYPE);

        $this->label = $label;
        $this->id = $id;
        $this->url = $url;
        $this->emoji = $emoji;
        $this->disabled = $disabled;
    }

    public function style(): int
    {
        return $this->style;
    }

    public function setStyle(int $style): void
    {
        $this->style = $style;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function setId(string $id = null): void
    {
        $this->id = $id;
    }

    public function hasId(): bool
    {
        return $this->id !== null;
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

    public function url(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function hasUrl(): bool
    {
        return $this->url !== null;
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
            'style' => $this->style,
            'disabled' => $this->disabled,
        ];

        if ($this->hasLabel()) {
            $data['label'] = $this->label();
        }

        if ($this->hasUrl()) {
            $data['url'] = $this->url();
        }

        if ($this->hasId()) {
            $data['custom_id'] = $this->id();
        }

        if ($this->emoji instanceof PartialEmoji) {
            $data['emoji'] = $this->emoji->jsonSerialize();
        }

        return array_filter(
            array_merge(
                parent::jsonSerialize(),
                $data,
            )
        );
    }
}
