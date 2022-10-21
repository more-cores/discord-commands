<?php

namespace DiscordBuilder\Commands\Interactions;

use DiscordBuilder\Commands\Interactions\Data\ApplicationCommandData;
use DiscordBuilder\Commands\Interactions\Data\HasApplicationCommandData;
use DiscordBuilder\Hydrateable;

class Interaction implements Hydrateable
{
    protected ?string $id = null;
    protected ?string $applicationId = null;
    protected ?string $token = null;
    protected ?int $version = null;

    protected ?string $guildId = null;
    protected ?string $channelId = null;
    protected ?array $guildMember = null;

    protected ?array $user = null;

    public function __construct(
        protected int $type,
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function hasId(): bool
    {
        return $this->id !== null;
    }

    public function applicationId(): string
    {
        return $this->applicationId;
    }

    public function hasApplicationId(): bool
    {
        return $this->applicationId !== null;
    }

    public function guildId(): string
    {
        return $this->guildId;
    }

    public function hasGuildId(): bool
    {
        return $this->guildId !== null;
    }

    public function channelId(): string
    {
        return $this->channelId;
    }

    public function hasChannelId(): bool
    {
        return $this->channelId !== null;
    }

    public function guildMember(): array
    {
        return $this->guildMember;
    }

    public function hasGuildMember(): bool
    {
        return $this->guildMember !== null;
    }

    public function user(): array
    {
        return $this->user;
    }

    public function hasUser(): bool
    {
        return $this->user !== null;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function hasToken(): bool
    {
        return $this->token !== null;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function hasVersion(): bool
    {
        return $this->version !== null;
    }

    public function type(): int
    {
        return $this->type;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['id'])) {
            $this->id = $array['id'];
        }

        if (isset($array['applicationId'])) {
            $this->applicationId = $array['applicationId'];
        }

        if (isset($array['guildId'])) {
            $this->guildId = $array['guildId'];
        }

        if (isset($array['channelId'])) {
            $this->channelId = $array['channelId'];
        }

        if (isset($array['member'])) {
            $this->guildMember = $array['member'];
        }

        if (isset($array['user'])) {
            $this->user = $array['user'];
        }

        $traitsUsed = class_uses($this);
        if (isset($array['data']) && in_array(HasApplicationCommandData::class, $traitsUsed)) {
            $data = [];
            foreach ($array['data'] as $rawData) {
                $data[] = (new ApplicationCommandData())
                    ->hydrate($rawData);
            }
            $this->data = $data;
        }

        if (isset($array['token'])) {
            $this->token = $array['token'];
        }

        if (isset($array['version'])) {
            $this->version = $array['version'];
        }

        return $this;
    }
}