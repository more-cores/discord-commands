<?php

namespace DiscordCommands\Commands\Interactions\Responding;

use DiscordCommands\Commands\Options\Choices\Choice;
use DiscordCommands\Commands\Options\HasOptionChoices;
use DiscordCommands\Jsonable;

class ProvideAutocompleteOptions extends Jsonable implements CommandResponse
{
    public const TYPE = 8;

    use HasOptionChoices;

    /**
     * @param Choice[] $choices
     */
    public function __construct(
        array $choices = [],
    ) {
        $this->choices = $choices;
    }

    public function jsonSerialize(): array
    {
        $jsonData = [];

        $traitsUsed = array_merge(class_uses(self::class), class_uses($this));
        if (in_array(HasOptionChoices::class, $traitsUsed)) {
            $jsonData['choices'] = $this->serializeChoices();
        }

        return [
            'type' => self::TYPE,
            'data' => $jsonData,
        ];
    }
}
