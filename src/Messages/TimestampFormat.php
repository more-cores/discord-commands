<?php

namespace DiscordCommands\Messages;

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