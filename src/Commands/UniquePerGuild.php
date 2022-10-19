<?php

namespace DiscordBuilder\Commands;

trait UniquePerGuild
{
    protected ?string $guildId = null;

    public function guildId(): string
    {
        return $this->guildId;
    }

    public function setGuildId(string $guildId): void
    {
        $this->guildId = $guildId;
    }

    public function hasGuildId(): bool
    {
        return $this->guildId !== null;
    }
}