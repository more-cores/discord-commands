<?php

namespace DiscordBuilder\Commands;

use DiscordBuilder\Jsonable;

class Command extends Jsonable
{
    public const PERMISSION_DISABLE_FOR_NON_ADMINS = 0;

    protected ?string $applicationId = null;
    protected string $name = '';
    protected string $description = '';
    protected ?string $defaultMemberPermissions = null;
    protected ?bool $dmPermission = null;
    protected ?string $version = null;

    public function __construct(
        protected int $type,
        ?string $applicationId = null,
        string $name = '',
        string $description = '',
        ?bool $dmPermission = null,
        ?bool $defaultMemberPermissions = null,
        ?bool $version = null,
    ) {
        $this->description = $description;
        $this->applicationId = $applicationId;
        $this->name = $name;
        $this->defaultMemberPermissions = $defaultMemberPermissions;
        $this->dmPermission = $dmPermission;
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

    public function setDefaultMemberPermissions(?string $defaultMemberPermissions = null): void
    {
        $this->defaultMemberPermissions = $defaultMemberPermissions;
    }

    public function hasDefaultMemberPermissions(): bool
    {
        return $this->defaultMemberPermissions !== null;
    }

    public function dmPermission(): ?bool
    {
        return $this->dmPermission;
    }

    public function setDmPermission(?string $dmPermission = null): void
    {
        $this->dmPermission = $dmPermission;
    }

    public function hasDmPermission(): bool
    {
        return $this->dmPermission !== null;
    }

    public function disableForEveryoneButAdmins(): void
    {
        $this->setDefaultMemberPermissions(
            self::PERMISSION_DISABLE_FOR_NON_ADMINS
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

        if ($this->hasDmPermission()) {
            $data['dm_permission'] = $this->dmPermission();
        }

        if ($this->hasVersion()) {
            $data['version'] = $this->version();
        }

        if (in_array(UniquePerGuild::class, class_uses($this))) {
            $data['guild_id'] = $this->guildId();
        }

        if (in_array(HasCommandOptions::class, class_uses($this))) {
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