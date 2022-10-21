<?php

namespace DiscordBuilder\Commands\Types;

use DiscordBuilder\Commands\Command;
use DiscordBuilder\Commands\HasCommandOptions;

class ChatInputCommand extends Command
{
    use HasCommandOptions;

    public const TYPE = 1;

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
