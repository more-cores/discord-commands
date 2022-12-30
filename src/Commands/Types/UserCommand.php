<?php

namespace DiscordCommands\Commands\Types;

use DiscordCommands\Commands\Command;

class UserCommand extends Command
{
    public const TYPE = 2;

    public function __construct(
        ?string $applicationId = null,
        string $name = '',
        string $description = '',
        ?bool $availableInDms = null,
        array|int $defaultMemberPermissions = null,
        ?bool $version = null,
    ) {
        parent::__construct(
            type: self::TYPE,
            applicationId: $applicationId,
            name: $name,
            description: $description,
            availableInDms: $availableInDms,
            defaultMemberPermissions: $defaultMemberPermissions,
            version: $version,
        );
    }
}
