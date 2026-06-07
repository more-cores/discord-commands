<?php

namespace DiscordCommands\Commands\Interactions\Responding;

use DiscordCommands\Jsonable;

/**
 * Acknowledges a command interaction and shows a loading state to the user,
 * allowing you to send the actual reply later (within 15 minutes).  Useful when
 * the work needed to respond can't finish within Discord's 3 second window.
 */
class DeferReply extends Jsonable implements CommandResponse
{
    public const TYPE = 5;

    public const FLAG_EPHEMERAL = 0x0000000000000040;

    protected array $flags = [];

    public function __construct(
        ?bool $onlyVisibleToCommandIssuer = null,
    ) {
        if ($onlyVisibleToCommandIssuer !== null) {
            $this->onlyVisibleToCommandIssuer();
        }
    }

    public function onlyVisibleToCommandIssuer(): void
    {
        $this->flags[] = self::FLAG_EPHEMERAL;
    }

    public function jsonSerialize(): array
    {
        $response = [
            'type' => self::TYPE,
        ];

        if (count($this->flags) > 0) {
            $response['data'] = [
                'flags' => array_sum($this->flags),
            ];
        }

        return $response;
    }
}
