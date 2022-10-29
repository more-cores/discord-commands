<?php

namespace DiscordBuilder\Commands;

use DiscordBuilder\Jsonable;

class Command extends Jsonable
{
    public const PERMISSION_DISABLE_FOR_NON_ADMINS = 0;

    protected ?string $applicationId = null;
    protected string $name = '';
    protected string $description = '';
    protected ?int $defaultMemberPermissions = null;
    protected ?bool $availableInDms = null;
    protected ?string $version = null;

    public function __construct(
        protected int $type,
        ?string $applicationId = null,
        string $name = '',
        string $description = '',
        ?bool $availableInDms = null,
        array|int $defaultMemberPermissions = null,
        ?bool $version = null,
    ) {
        $this->description = $description;
        $this->applicationId = $applicationId;
        $this->name = $name;
        $this->setDefaultMemberPermissions($defaultMemberPermissions);
        $this->availableInDms = $availableInDms;
        $this->version = $version;
    }

    public function type(): int
    {
        return $this->type;
    }

    public function applicationId(): string
    {
        return $this->applicationId;
    }

    public function setApplicationId(?string $applicationId = null): void
    {
        $this->applicationId = $applicationId;
    }

    public function hasApplicationId(): bool
    {
        return $this->applicationId !== null;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name = ''): void
    {
        $this->name = $name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function setDescription(string $description = ''): void
    {
        $this->description = $description;
    }

    public function defaultMemberPermissions(): string
    {
        return $this->defaultMemberPermissions;
    }

    public function setDefaultMemberPermissions(array|int $defaultMemberPermissions = null): void
    {
        if (is_array($defaultMemberPermissions)) {
            $defaultMemberPermissions = array_sum($defaultMemberPermissions);
        }

        $this->defaultMemberPermissions = $defaultMemberPermissions;
    }

    public function hasDefaultMemberPermissions(): bool
    {
        return $this->defaultMemberPermissions !== null;
    }

    public function availableInDms(): bool
    {
        return $this->availableInDms;
    }

    public function setAvailableInDms(?bool $availableInDms = null): void
    {
        $this->availableInDms = $availableInDms;
    }

    public function hasAvailableInDms(): bool
    {
        return $this->availableInDms !== null;
    }

    public function disableForEveryoneButAdmins(): void
    {
        $this->setDefaultMemberPermissions(
            self::PERMISSION_DISABLE_FOR_NON_ADMINS,
        );
    }

    public function version(): string
    {
        return $this->version;
    }

    public function setVersion(?string $version = null): void
    {
        $this->version = $version;
    }

    public function hasVersion(): bool
    {
        return $this->version !== null;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'type' => $this->type(),
            'name' => $this->name(),
            'description' => $this->description(),
        ];

        if ($this->hasApplicationId()) {
            $data['application_id'] = $this->applicationId();
        }

        if ($this->hasDefaultMemberPermissions()) {
            $data['default_member_permissions'] = $this->defaultMemberPermissions();
        }

        if ($this->hasAvailableInDms()) {
            $data['dm_permission'] = $this->availableInDms();
        }

        if ($this->hasVersion()) {
            $data['version'] = $this->version();
        }

        $traitsUsed = array_merge(class_uses(self::class), class_uses($this));
        if (in_array(UniquePerGuild::class, $traitsUsed)) {
            $data['guild_id'] = $this->guildId();
        }

        if (in_array(HasCommandOptions::class, $traitsUsed)) {
            if ($this->hasOptions()) {
                $data['options'] = [];

                foreach ($this->options() as $option) {
                    $data['options'][] = $option->jsonSerialize();
                }
            }
        }

        return array_filter($data);
    }
}