<?php

namespace DiscordCommands\Commands\Interactions\Types;

use DiscordCommands\Commands\Interactions\Interaction;

/**
 * Sent by Discord when a user interacts with a message component, such as
 * clicking a button or making a selection in a select menu.
 */
class ComponentInteracted extends Interaction
{
    public const TYPE = 3;

    protected ?string $customId = null;
    protected ?int $componentType = null;
    protected array $values = [];
    protected ?array $message = null;

    public function __construct()
    {
        parent::__construct(
            type: self::TYPE,
        );
    }

    /**
     * The custom_id of the component that was interacted with.
     */
    public function customId(): string
    {
        return (string) $this->customId;
    }

    public function hasCustomId(): bool
    {
        return $this->customId !== null;
    }

    /**
     * The type of the component that was interacted with (e.g. 2 for a button,
     * 3 for a string select menu).
     */
    public function componentType(): ?int
    {
        return $this->componentType;
    }

    public function isButton(): bool
    {
        return $this->componentType === 2;
    }

    public function isSelectMenu(): bool
    {
        return in_array($this->componentType, [3, 5, 6, 7, 8], true);
    }

    /**
     * The values selected in a select menu.  Empty for buttons.
     *
     * @return string[]
     */
    public function values(): array
    {
        return $this->values;
    }

    public function hasValues(): bool
    {
        return count($this->values) > 0;
    }

    /**
     * The message the interacted component is attached to.  Useful when
     * responding with an UpdateMessage to edit it in place.
     */
    public function message(): ?array
    {
        return $this->message;
    }

    public function hasMessage(): bool
    {
        return $this->message !== null;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['data']['custom_id'])) {
            $this->customId = $array['data']['custom_id'];
        }

        if (isset($array['data']['component_type'])) {
            $this->componentType = $array['data']['component_type'];
        }

        if (isset($array['data']['values'])) {
            $this->values = $array['data']['values'];
        }

        if (isset($array['message'])) {
            $this->message = $array['message'];
        }

        return parent::hydrate($array);
    }
}
