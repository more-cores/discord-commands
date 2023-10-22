<?php

namespace DiscordCommands\Messages;

/**
 * @link https://discord.com/developers/docs/reference#message-formatting-timestamp-styles
 */
enum TimestampFormat: string
{
    case RELATIVE = 'R';
    case SHORT_TIME = 't';
    case LONG_TIME = 'T';
    case SHORT_DATE = 'd';
    case LONG_DATE = 'D';
    case SHORT_DATETIME = 'f';
    case LONG_DATETIME = 'F';
}