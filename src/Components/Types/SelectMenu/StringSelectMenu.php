<?php

namespace DiscordBuilder\Components\Types\SelectMenu;

use DiscordBuilder\Components\Types\SelectMenu;

class StringSelectMenu extends SelectMenu
{
    public const TYPE = 3;

    protected array $options = [];

    /**
     * @param Option[] $options
     */
    public function __construct(
        string $id,
        array $options = [],
    ) {
        parent::__construct(
            type: self::TYPE,
            id: $id
        );

        $this->options = $options;
    }

    public function makeDefault(string $optionLabel): void
    {
        foreach ($this->options as $option) {
            $option->setDefault(
                $optionLabel === $option->label()
            );
        }
    }

    public function options(): array
    {
        return $this->options;
    }

    /**
     * @param Option[] $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function addOptions(Option $option): void
    {
        $this->options[] = $option;
    }

    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();

        foreach ($this->options as $option) {
            $data['options'][] = $option->jsonSerialize();
        }

        return $data;
    }


}