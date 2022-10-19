<?php

namespace DiscordBuilder\Commands\Types;

use DiscordBuilder\Commands\Command;
use DiscordBuilder\Commands\HasCommandOptions;

class ChatInputCommand extends Command
{
    use HasCommandOptions;

    public const TYPE = 1;

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}
