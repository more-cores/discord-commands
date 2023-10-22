<?php

namespace DiscordCommands\Messages;

enum Mention: string
{
    case Everyone = '@everyone';
    case Here = '@here';

    public static function user(string $userId): string
    {
        return '<@' . $userId . '>';
    }

    public static function role(string $roleId): string
    {
        return '<@&' . $roleId . '>';
    }

    /**
     * @deprecated Use Mention::role() instead
     */
    public static function other(int $roleId): string
    {
        return self::role($roleId);
    }

    public static function hasMentions(string $content): bool
    {
        return preg_match('#<@.+?>#', $content) ||
            str_contains($content, self::Everyone->value) ||
            str_contains($content, self::Here->value);
    }
}