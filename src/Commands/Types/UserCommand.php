<?php

namespace DiscordBuilder\Commands\Types;

use DiscordBuilder\Commands\Command;

class UserCommand extends Command
{
    public const TYPE = 2;

    public function __construct(
        ?string $applicationId = null,
        string $name = '',
        string $description = '',
        ?bool $dmPermission = null,
        ?bool $defaultMemberPermissions = null,
        ?bool $version = null,
    ) {
        parent::__construct(
            type: self::TYPE,
            applicationId: $applicationId,
            name: $name,
            description: $description,
            dmPermission: $dmPermission,
            defaultMemberPermissions: $defaultMemberPermissions,
            version: $version,
        );
    }
}