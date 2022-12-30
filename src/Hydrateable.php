<?php

namespace DiscordCommands;

interface Hydrateable
{
    public function hydrate(array $array): self;
}
