<?php

namespace DiscordBuilder\Commands\Types;

use DiscordBuilder\Commands\Command;

class MessageCommand extends Command
{
    public const TYPE = 3;

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
