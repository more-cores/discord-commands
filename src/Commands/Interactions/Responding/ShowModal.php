<?php

namespace DiscordCommands\Commands\Interactions\Responding;

use DiscordCommands\Jsonable;
use DiscordCommands\Messages\Components\Component;
use DiscordCommands\Messages\Components\HasComponents;
use DiscordCommands\Messages\Components\Types\ActionRow;

class ShowModal extends Jsonable implements CommandResponse
{
    public const TYPE = 9;

    use HasComponents;

    protected ?string $id;
    protected ?string $title;

    /**
     * @param ActionRow[]|null $components
     */
    public function __construct(
        ?string $id = null,
        ?string $title = null,
        array $components = [],
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->components = $components;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function title(): string
    {
        return (string) $this->title;
    }

    public function actionRow(Component ... $components)
    {
        $this->addComponent(new ActionRow(func_get_args()));
    }

    public function jsonSerialize(): array
    {
        $jsonData = [
            'custom_id' => $this->id(),
            'title' => $this->title(),
        ];

        $traitsUsed = array_merge(class_uses(self::class), class_uses($this));
        if (in_array(HasComponents::class, $traitsUsed)) {
            $jsonData['components'] = $this->serializeComponents();
        }

        return [
            'type' => self::TYPE,
            'data' => $jsonData,
        ];
    }
}
