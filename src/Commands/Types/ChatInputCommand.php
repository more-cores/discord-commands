<?php

namespace DiscordCommands\Commands\Types;

use DiscordCommands\Commands\Command;
use DiscordCommands\Commands\HasCommandOptions;

class ChatInputCommand extends Command
{
    use HasCommandOptions;

    public const TYPE = 1;

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
