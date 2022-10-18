<?php

namespace DiscordBuilder;

class Command extends Jsonable
{
    public const PERMISSION_DISABLE_FOR_NON_ADMINS = 0;

    protected ?string $applicationId = null;
    protected ?string $guildId = null;
    protected string $name = '';
    protected string $description = '';
    protected ?string $defaultMemberPermissions = null;
    protected ?bool $dmPermission = null;
    protected ?string $version = null;

    public function __construct(
        protected int $type,
        ?string $applicationId = null,
        ?string $guildId = null,
        string $name = '',
        string $description = '',
        ?bool $dmPermission = null,
        ?bool $defaultMemberPermissions = null,
        ?bool $version = null,
    ) {
        $this->description = $description;
        $this->applicationId = $applicationId;
        $this->guildId = $guildId;
        $this->name = $name;
        $this->defaultMemberPermissions = $defaultMemberPermissions;
        $this->dmPermission = $dmPermission;
        $this->version = $version;
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

    public function guildId(): string
    {
        return $this->guildId;
    }

    public function setGuildId(?string $guildId = null): void
    {
        $this->guildId = $guildId;
    }

    public function hasGuildId(): bool
    {
        return $this->guildId !== null;
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
            'application_id' => $this->applicationId,
            'guild_id' => $this->guildId,
            'name' => $this->name,
            'description' => $this->description,
            'default_member_permissions' => $this->defaultMemberPermissions,
            'dm_permission' => $this->dmPermission,
            'version' => $this->version,
        ];

        return array_filter($data);
    }
}