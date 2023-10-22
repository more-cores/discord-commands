<?php

namespace DiscordCommands\Messages;

/**
 * @see https://discord.com/developers/docs/reference#message-formatting-guild-navigation-types
 */
enum GuildNavigation: string
{
    case SERVER_GUIDE = 'guide';
    case CHANNEL_BROWSER = 'browse';
    case CUSTOMIZE_SERVER = 'customize';
}