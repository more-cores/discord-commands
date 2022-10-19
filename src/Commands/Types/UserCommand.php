<?php

namespace DiscordBuilder\Commands\Types;

use DiscordBuilder\Commands\Command;

class UserCommand extends Command
{
    public const TYPE = 2;

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }
}
