<?php

namespace DiscordBuilder\Messages;

use DiscordBuilder\Hydrateable;
use DiscordBuilder\Jsonable;
use DiscordBuilder\Messages\Components\Component;
use DiscordBuilder\Messages\Components\HasComponents;
use DiscordBuilder\Messages\Embed\Embed;

class WebhookMessage extends Jsonable implements Hydrateable
{
    use HasComponents;
    use HasEmbeds;

    protected ?string $content;
    protected ?string $threadName;
    protected ?string $webhookUsername;
    protected ?string $webhookAvatarUrl;

    /**
     * @param string|null $content
     * @param Embed[]|null $embeds
     * @param Component[]|null $components
     */
    public function __construct(
        ?string $content = null,
        array $embeds = [],
        array $components = [],
        ?string $threadName = null,
        ?string $webhookUsername = null,
        ?string $webhookAvatarUrl = null,
    ) {
        $this->content = $content;
        $this->embeds = $embeds;
        $this->components = $components;
        $this->threadName = $threadName;
        $this->webhookUsername = $webhookUsername;
        $this->webhookAvatarUrl = $webhookAvatarUrl;
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

    /**
     * Determine if the given message has mentions
     */
    public function hasMentions(): bool
    {
        return preg_match('#<@&.+?>#', $this->content());
    }

    public function mentionedRoleIds(): array
    {
        preg_match_all('#<@&(.+?)>#', $this->content(), $matches);

        return $matches[1] ?? [];
    }

    /**
     * Mention the given role in the included message
     */
    public function mention(int $roleId): void
    {
        $this->content .= '<@&'.$roleId.'> ';
    }

    public function isMentioned(int $roleId): bool
    {
        if ($this->content == null) {
            return false;
        }

        return str_contains($this->content, '<@&' . $roleId . '>');
    }

    public function createThreadWithName(string $threadName)
    {
        $this->threadName = $threadName;
    }

    public function threadNameToCreate(): string
    {
        return $this->threadName;
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
            'username' => $this->webhookUsername,
            'avatar_url' => $this->webhookAvatarUrl,
        ];

        if (isset($this->threadName)) {
            $jsonData['thread_name'] = $this->threadName;
        }

        $traitsUsed = class_uses(self::class);
        if (in_array(HasComponents::class, $traitsUsed)) {
            $jsonData['components'] = $this->serializeComponents();
        }
        if (in_array(HasEmbeds::class, $traitsUsed)) {
            $jsonData['embeds'] = $this->serializeEmbeds();
        }

        return $jsonData;
    }
}
