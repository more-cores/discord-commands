<?php

namespace DiscordCommands;

abstract class Jsonable implements \JsonSerializable
{
    public function toJson(int $options = JSON_FORCE_OBJECT) : string
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
