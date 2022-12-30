<?php

namespace DiscordCommands\Permissions;

/**
 * @link https://discordapi.com/permissions.html
 * @link https://discord.com/developers/docs/topics/permissions#permissions-bitwise-permission-flags
 */
class Permission
{
    public const CREATE_INSTANT_INVITE      = 0x0000000000000001;
    public const KICK_MEMBERS               = 0x0000000000000002;
    public const BAN_MEMBERS                = 0x0000000000000004;
    public const ADMINISTRATOR              = 0x0000000000000008;
    public const MANAGE_CHANNELS            = 0x0000000000000010;
    public const MANAGE_GUILD               = 0x0000000000000020;
    public const ADD_REACTIONS              = 0x0000000000000040;
    public const VIEW_AUDIT_LOG             = 0x0000000000000080;
    public const PRIORITY_SPEAKER           = 0x0000000000000100;
    public const STREAM                     = 0x0000000000000200;
    public const VIEW_CHANNEL               = 0x0000000000000400; // also includes reading messages
    public const SEND_MESSAGES              = 0x0000000000000800;
    public const SEND_TTS_MESSAGES          = 0x0000000000001000;
    public const MANAGE_MESSAGES            = 0x0000000000002000;
    public const EMBED_LINKS                = 0x0000000000004000;
    public const ATTACH_FILES               = 0x0000000000008000;
    public const READ_MESSAGE_HISTORY       = 0x0000000000010000;
    public const MENTION_EVERYONE           = 0x0000000000020000;
    public const USE_EXTERNAL_EMOJIS        = 0x0000000000040000;
    public const VIEW_GUILD_INSIGHTS        = 0x0000000000080000;
    public const CONNECT                    = 0x0000000000100000;
    public const SPEAK                      = 0x0000000000200000;
    public const MUTE_MEMBERS               = 0x0000000000400000;
    public const DEAFEN_MEMBERS             = 0x0000000000800000;
    public const MOVE_MEMBERS               = 0x0000000001000000;
    public const USE_VAD                    = 0x0000000002000000;
    public const CHANGE_NICKNAME            = 0x0000000004000000;
    public const MANAGE_NICKNAMES           = 0x0000000008000000;
    public const MANAGE_ROLES               = 0x0000000010000000;
    public const MANAGE_WEBHOOKS            = 0x0000000020000000;
    public const MANAGE_EMOJIS_AND_STICKERS = 0x0000000040000000;
    public const USE_APPLICATION_COMMANDS   = 0x0000000080000000;
    public const REQUEST_TO_SPEAK           = 0x0000000100000000;
    public const MANAGE_EVENTS              = 0x0000000200000000;
    public const MANAGE_THREADS             = 0x0000000400000000;
    public const CREATE_PUBLIC_THREADS      = 0x0000000800000000;
    public const CREATE_PRIVATE_THREADS     = 0x0000001000000000;
    public const USE_EXTERNAL_STICKERS      = 0x0000002000000000;
    public const SEND_MESSAGES_IN_THREADS   = 0x0000004000000000;
    public const USE_EMBEDDED_ACTIVITIES    = 0x0000008000000000;
    public const MODERATE_MEMBERS           = 0x0000010000000000;
}
