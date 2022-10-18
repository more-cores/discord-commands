<?php

namespace DiscordBuilder;

class Channel
{
    /**
     * @link https://discord.com/developers/docs/resources/channel#channel-object-channel-types
     */
    public const TYPE_GUILD_TEXT = 0;
    public const TYPE_DIRECT_MESSAGE = 1;
    public const TYPE_GUILD_VOICE = 2;
    public const TYPE_GROUP_DIRECT_MESSAGE = 3;
    public const TYPE_GUILD_CATEGORY = 4;
    public const TYPE_GUILD_ANNOUNCEMENT = 5;
    public const TYPE_ANNOUNCEMENT_THREAD = 10;
    public const TYPE_PUBLIC_THREAD = 11;
    public const TYPE_PRIVATE_THREAD = 12;
    public const TYPE_GUILD_STAGE_VOICE = 13;
    public const TYPE_GUILD_DIRECTORY = 14;
    public const TYPE_GUILD_FORUM = 15;
}