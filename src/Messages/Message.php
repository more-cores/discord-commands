<?php

namespace DiscordBuilder\Messages;

use DiscordBuilder\Hydrateable;
use DiscordBuilder\Jsonable;
use DiscordBuilder\Messages\Components\Component;
use DiscordBuilder\Messages\Components\HasComponents;
use DiscordBuilder\Messages\Components\Types\ActionRow;
use DiscordBuilder\Messages\Components\Types\Button;
use DiscordBuilder\Messages\Embed\Embed;

class Message extends Jsonable implements Hydrateable
{
    use HasComponents;
    use HasEmbeds;

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

    /**
     * Determine if the given message has mentions
     */
    public function hasMentions(): bool
    {
        return preg_match('#<@&.+?>#', $this->content());
    }

    public function mentionedRoleIds(): ?array
    {
        preg_match_all('#<@&(.+?)>#', $this->content(), $matches);

        return isset($matches[1]) ? $matches[1] : null;
    }

    /**
     * Mention the given role in the included message
     */
    public function mention(int $roleId): void
    {
        $this->content .= '<@&'.$roleId.'>';
    }

    public function isMentioned(int $roleId): bool
    {
        if ($this->content == null) {
            return false;
        }

        return str_contains($this->content, '<@&' . $roleId . '>');
    }

    public function actionRow(Button ... $components)
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
}
