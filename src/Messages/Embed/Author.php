<?php

namespace DiscordBuilder\Messages\Embed;

use DiscordBuilder\Hydrateable;
use DiscordBuilder\Jsonable;

class Author extends Jsonable implements Hydrateable
{
    protected ?string $name = null;
    protected ?string $url = null;
    protected ?string $iconUrl = null;
    protected ?string $proxyIconUrl = null;

    public function __construct(
        ?string $name = null,
        ?string $url = null,
        ?string $iconUrl = null,
        ?string $proxyIconUrl = null,
    ) {
        $this->name = $name;
        $this->url = $url;
        $this->iconUrl = $iconUrl;
        $this->proxyIconUrl = $proxyIconUrl;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function hasName(): bool
    {
        return $this->name !== null;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function hasUrl(): bool
    {
        return $this->url !== null;
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
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }

        if (isset($array['url'])) {
            $this->setUrl($array['url']);
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
        $data = [];

        if ($this->hasName()) {
            $data['name'] = $this->name();
        }

        if ($this->hasUrl()) {
            $data['url'] = $this->url();
        }

        if ($this->hasIconUrl()) {
            $data['icon_url'] = $this->iconUrl();
        }

        if ($this->hasProxyIconUrl()) {
            $data['proxy_icon_url'] = $this->proxyIconUrl();
        }

        return $data;
    }
}
