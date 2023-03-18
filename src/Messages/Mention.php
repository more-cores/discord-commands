<?php

namespace DiscordCommands\Messages;

enum Mention: string
{
    case Everyone = '@everyone';
    case Here = '@here';

    public static function other(int $roleId)
    {
        return '<@&'.$roleId.'>';
    }

    public static function hasMentions(string $content)
    {
        return preg_match('#<@&.+?>#', $content) ||
            str_contains($content, self::Everyone->value) ||
            str_contains($content, self::Here->value);
    }
}