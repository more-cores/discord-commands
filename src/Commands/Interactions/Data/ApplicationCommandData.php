<?php

namespace DiscordBuilder\Commands\Interactions\Data;

use DiscordBuilder\Hydrateable;

class ApplicationCommandData implements Hydrateable
{
    protected ?string $id = null;
    protected ?string $name = null;
    protected ?string $type = null;
    protected array $resolved = [];
    protected ?string $guildId = null;
    protected ?string $targetId = null;
    protected array $options = [];

    public function commandId(): string
    {
        return $this->id;
    }

    public function commandName(): string
    {
        return $this->name;
    }

    public function commandType(): string
    {
        return $this->type;
    }

    public function resolved(): array
    {
        return $this->resolved;
    }

    public function hasResolved(): bool
    {
        return count($this->resolved) > 0;
    }

    public function options(): array
    {
        return $this->options;
    }

    public function hasOptions(): bool
    {
        return count($this->options) > 0;
    }

    public function guildId(): string
    {
        return $this->guildId;
    }

    public function hasGuildId(): bool
    {
        return $this->guildId !== null;
    }

    public function targetId(): string
    {
        return $this->targetId;
    }

    public function hasTargetId(): bool
    {
        return $this->targetId !== null;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['id'])) {
            $this->id = $array['id'];
        }

        if (isset($array['name'])) {
            $this->name = $array['name'];
        }

        if (isset($array['type'])) {
            $this->type = $array['type'];
        }

        if (isset($array['resolved'])) {
            $this->resolved = $array['resolved'];
        }

        if (isset($array['options'])) {
            foreach ($array['options'] as $optionData) {
                $this->options[] = (new ApplicationCommandDataOption())
                    ->hydrate($optionData);
            }
        }

        if (isset($array['guild_id'])) {
            $this->guildId = $array['guild_id'];
        }

        if (isset($array['target_id'])) {
            $this->targetId = $array['target_id'];
        }

        return $this;
    }
}