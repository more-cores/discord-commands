<?php

namespace DiscordBuilder\Commands;

use DiscordBuilder\Command;

class MessageCommand extends Command
{
    public const TYPE = 3;

    public function __construct(
    ) {
        parent::__construct(
            type: self::TYPE,
        );
    }
}
