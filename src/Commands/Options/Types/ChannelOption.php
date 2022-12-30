<?php

namespace DiscordCommands\Commands\Options\Types;

use DiscordCommands\Commands\Options\Option;

class ChannelOption extends Option
{
    public const TYPE = 7;

    protected array $channelTypes = [];

    /**
     * @param int[] $channelTypes
     */
    public function __construct(
        string $name = '',
        string $description = '',
        bool $required = false,
        array $channelTypes = [],
    ) {
        parent::__construct(
            type: self::TYPE,
            name: $name,
            description: $description,
            required: $required,
        );

        $this->channelTypes = $channelTypes;
    }

    public function hasChannelTypes(): bool
    {
        return count($this->channelTypes) > 0;
    }

    /**
     * @return int[]
     */
    public function channelTypes(): array
    {
        return $this->channelTypes;
    }

    /**
     * @param int[] $channelTypes
     */
    public function setChannelTypes(array $channelTypes): void
    {
        $this->channelTypes = $channelTypes;
    }

    public function addChannelType(int $channelType): void
    {
        $this->channelTypes[] = $channelType;
    }

    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->hasChannelTypes()) {
            $data['channel_types'] = $this->channelTypes();
        }

        return array_filter(
            array_merge(
                parent::jsonSerialize(),
                $data,
            )
        );
    }
}
