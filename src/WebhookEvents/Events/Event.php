<?php

namespace DiscordCommands\WebhookEvents\Events;

use DiscordCommands\Hydrateable;

interface Event extends Hydrateable
{
    public function id(): string;
}