<?php

namespace DiscordBuilder;

interface Hydrateable
{
    public function hydrate(array $array): self;
}
