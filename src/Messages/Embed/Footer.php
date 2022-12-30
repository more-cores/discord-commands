<?php

namespace DiscordCommands\Messages\Embed;

use DiscordCommands\Hydrateable;
use DiscordCommands\Jsonable;

class Footer extends Jsonable implements Hydrateable
{
    protected ?string $iconUrl = null;
    protected ?string $proxyIconUrl = null;

    public function __construct(
        protected string $text = '',
        ?string $iconUrl = null,
        ?string $proxyIconUrl = null,
    ) {
        $this->iconUrl = $iconUrl;
        $this->proxyIconUrl = $proxyIconUrl;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function setIconUrl(string $iconUrl): void
    {
        $this->iconUrl = $iconUrl;
    }

    public function iconUrl(): string
    {
        return $this->iconUrl;
    }

    public function hasIconUrl(): bool
    {
        return $this->iconUrl !== null;
    }

    public function setProxyIconUrl(string $proxyIconUrl): void
    {
        $this->proxyIconUrl = $proxyIconUrl;
    }

    public function proxyIconUrl(): string
    {
        return $this->proxyIconUrl;
    }

    public function hasProxyIconUrl(): bool
    {
        return $this->proxyIconUrl !== null;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['text'])) {
            $this->setText($array['text']);
        }

        if (isset($array['icon_url'])) {
            $this->setIconUrl($array['icon_url']);
        }

        if (isset($array['proxy_icon_url'])) {
            $this->setProxyIconUrl($array['proxy_icon_url']);
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'text' => $this->text(),
        ];

        if ($this->hasIconUrl()) {
            $data['icon_url'] = $this->iconUrl();
        }

        if ($this->hasProxyIconUrl()) {
            $data['proxy_icon_url'] = $this->proxyIconUrl();
        }

        return $data;
    }
}
