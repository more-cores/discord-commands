<?php

namespace DiscordBuilder\Commands\Interactions\Responding;

use DiscordBuilder\Commands\Options\Choices\Choice;
use DiscordBuilder\Commands\Options\HasOptionChoices;
use DiscordBuilder\Jsonable;

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

        $traitsUsed = class_uses($this);
        if (in_array(HasOptionChoices::class, $traitsUsed)) {
            $jsonData['choices'] = $this->serializeChoices();
        }

        return [
            'type' => self::TYPE,
            'data' => $jsonData,
        ];
    }
}
