<?php

namespace DiscordBuilder\Components\Types;

use DiscordBuilder\Components\Component;

class ActionRow extends Component
{
    public const TYPE = 1;

    protected array $components = [];

    /**
     * @param Component[] $components
     */
    public function __construct(
        array $components = [],
    ) {
        parent::__construct(self::TYPE);

        $this->components = $components;
    }

    /**
     * @return Component[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function addComponent(Component $component)
    {
        $this->components[] = $component;
    }

    /**
     * @param Component[] $components
     */
    public function setComponents(array $components): void
    {
        $this->components = $components;
    }

    public function jsonSerialize(): array
    {
        $componentJson = [];
        foreach ($this->components as $component) {
            $componentJson[] = $component->jsonSerialize();
        }

        return array_filter(
            array_merge(
                parent::jsonSerialize(),
                [
                    'components' => $componentJson,
                ],
            )
        );
    }
}
