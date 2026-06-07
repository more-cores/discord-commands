<?php

namespace DiscordCommands\Commands\Interactions\Responding;

use DiscordCommands\Jsonable;
use DiscordCommands\Messages\Components\Component;
use DiscordCommands\Messages\Components\HasComponents;
use DiscordCommands\Messages\Embed\Embed;
use DiscordCommands\Messages\HasEmbeds;

/**
 * Responds to a component interaction by editing the message the component is
 * attached to, rather than sending a new message.
 */
class UpdateMessage extends Jsonable implements CommandResponse
{
    public const TYPE = 7;

    public const FLAG_SUPPRESS_EMBEDS = 0x0000000000000004;

    use HasComponents;
    use HasEmbeds;

    protected ?string $content;
    protected array $embeds = [];
    protected array $flags = [];

    /**
     * @param string|null $content
     * @param Embed[]|null $embeds
     * @param Component[]|null $components
     */
    public function __construct(
        ?string $content = null,
        array $embeds = [],
        array $components = [],
        ?bool $withoutExpandingEmbeds = null,
    ) {
        $this->content = $content;
        $this->embeds = $embeds;
        $this->components = $components;

        if ($withoutExpandingEmbeds !== null) {
            $this->withoutExpandingEmbeds();
        }
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function content(): string
    {
        return (string) $this->content;
    }

    public function hasContent(): bool
    {
        return $this->content != null;
    }

    public function withoutExpandingEmbeds(): void
    {
        $this->flags[] = self::FLAG_SUPPRESS_EMBEDS;
    }

    public function jsonSerialize(): array
    {
        $jsonData = [
            'content' => $this->content(),
        ];

        if (count($this->flags) > 0) {
            $jsonData['flags'] = array_sum($this->flags);
        }

        $traitsUsed = array_merge(class_uses(self::class), class_uses($this));
        if (in_array(HasComponents::class, $traitsUsed)) {
            $jsonData['components'] = $this->serializeComponents();
        }
        if (in_array(HasEmbeds::class, $traitsUsed)) {
            $jsonData['embeds'] = $this->serializeEmbeds();
        }

        return [
            'type' => self::TYPE,
            'data' => $jsonData,
        ];
    }
}
