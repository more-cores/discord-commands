<?php

namespace DiscordCommands\Messages;

use DiscordCommands\Hydrateable;
use DiscordCommands\Jsonable;
use DiscordCommands\Messages\Components\Component;
use DiscordCommands\Messages\Components\HasComponents;
use DiscordCommands\Messages\Components\Types\ActionRow;
use DiscordCommands\Messages\Components\Types\Button;
use DiscordCommands\Messages\Embed\Embed;

/**
 * @see Mention
 */
class Message extends Jsonable implements Hydrateable
{
    use HasComponents;
    use HasEmbeds;
    use MentionsRoles;

    protected ?string $content;

    /**
     * @param string|null $content
     * @param Embed[]|null $embeds
     * @param Component[]|null $components
     */
    public function __construct(
        ?string $content = null,
        array $embeds = [],
        array $components = [],
    ) {
        $this->content = $content;
        $this->embeds = $embeds;
        $this->components = $components;
    }

    /**
     * Set the content of a message.  Will override any roles you have mentioned
     */
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

    public function actionRow(Button ... $buttons)
    {
        $this->addComponent(new ActionRow(func_get_args()));
    }

    public function hydrate(array $array): self
    {
        if (isset($array['content'])) {
            $this->setContent($array['content']);
        }

        // Component hydration is not currently supported - PR's welcome

        if (isset($array['embeds'])) {
            $this->hydrateEmbeds($array['embeds']);
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        $jsonData = [
            'content' => $this->content(),
        ];

        $traitsUsed = array_merge(class_uses(self::class), class_uses($this));
        if (in_array(HasComponents::class, $traitsUsed)) {
            $jsonData['components'] = $this->serializeComponents();
        }
        if (in_array(HasEmbeds::class, $traitsUsed)) {
            $jsonData['embeds'] = $this->serializeEmbeds();
        }

        return $jsonData;
    }

    /**
     * Adds a link in a channel to a message or embed
     */
    public static function linkChannel(string $channelId): string
    {
        return '<#' . $channelId . '>';
    }

    /**
     * Adds a link to a special guild channel in a message or embed
     */
    public static function linkInGuild(GuildNavigation $guildNavigation): string
    {
        return '<id:' . $guildNavigation->value . '>';
    }

    /**
     * Embeds a custom emoji in a message or embed
     */
    public static function customEmoji(
        string $name,
        string $id,
        bool $animated = false
    ): string {
        if ($animated) {
            return '<a:' . $name . ':' . $id . '>';
        }

        return '<:' . $name . ':' . $id . '>';
    }

    /**
     * Render a timestamp in the user's local time in a message or embed
     */
    public static function timestamp(
        int $timestamp,
        TimestampFormat $format = null
    ): string {
        if ($format !== null) {
            return '<t:' . $timestamp . ':' . $format->value . '>';
        }

        return '<t:' . $timestamp . '>';
    }
}
