<?php

namespace DiscordBuilder\Commands\Interactions;

use DiscordBuilder\Commands\Interactions\ExecutionResults\HasExecutionResults;
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

        if (isset($array['application_id'])) {
            $this->applicationId = $array['application_id'];
        }

        if (isset($array['guild_id'])) {
            $this->guildId = $array['guild_id'];
        }

        if (isset($array['channel_id'])) {
            $this->channelId = $array['channel_id'];
        }

        if (isset($array['member'])) {
            $this->guildMember = $array['member'];
        }

        if (isset($array['user'])) {
            $this->user = $array['user'];
        }

        $traitsUsed = array_merge(class_uses(self::class), class_uses($this));
        if (isset($array['data']) && in_array(HasExecutionResults::class, $traitsUsed)) {
            $this->hydrateExecutionResults($array['data']);
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