<?php

namespace DiscordBuilder\Components\Types\SelectMenu;

use DiscordBuilder\Components\Types\SelectMenu;

class ChannelSelectMenu extends SelectMenu
{
    public const TYPE = 8;
    protected array $channelTypes;

    public function __construct(
        string $id,
        array $channelTypes = [],
    ) {
        parent::__construct(
            type: self::TYPE,
            id: $id
        );

        $this->channelTypes = $channelTypes;
    }

    public function hasChannelTypes(): bool
    {
        return count($this->channelTypes) > 0;
    }

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

    public function addChannelType(Option $channelType): void
    {
        $this->channelTypes[] = $channelType;
    }

    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->hasChannelTypes()) {
            $data['channel_types'] = $this->channelTypes;
        }

        return array_filter(
            array_merge(
                parent::jsonSerialize(),
                $data,
            )
        );
    }
}