<?php

namespace DiscordBuilder\Commands;

use DiscordBuilder\Command;

class ChatInputCommand extends Command
{
    public const TYPE = 1;

    protected array $options = [];

    /**
     * @param Option[] $options
     */
    public function __construct(
        array $options = [],
    ) {
        parent::__construct(
            type: self::TYPE,
        );

        $this->options = $options;
    }

    public function hasOptions(): bool
    {
        return count($this->options) > 0;
    }

    /**
     * @return Option[]
     */
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

    public function addOption(Option $option): void
    {
        $this->options[] = $option;
    }

    public function jsonSerialize(): array
    {
        $data = [];

        return array_filter(
            array_merge(
                parent::jsonSerialize(),
                $data,
            )
        );
    }
}
