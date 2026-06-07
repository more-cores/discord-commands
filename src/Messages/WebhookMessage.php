<?php

namespace DiscordCommands\Messages;

use DiscordCommands\Hydrateable;
use DiscordCommands\Jsonable;
use DiscordCommands\Messages\Components\Component;
use DiscordCommands\Messages\Components\HasComponents;
use DiscordCommands\Messages\Embed\Embed;

class WebhookMessage extends Jsonable implements Hydrateable
{
    use HasComponents;
    use HasEmbeds;
    use MentionsRoles;

    public const FLAG_SUPPRESS_EMBEDS = 0x0000000000000004;
    public const FLAG_SUPPRESS_NOTIFICATIONS = 0x0000000000001000;

    protected ?string $content;
    protected ?string $threadName;
    protected ?string $webhookUsername;
    protected ?string $webhookAvatarUrl;
    protected array $flags = [];
    protected bool $tts = false;
    protected ?AllowedMentions $allowedMentions = null;

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

    public function createThreadWithName(string $threadName)
    {
        $this->threadName = $threadName;
    }

    public function threadNameToCreate(): string
    {
        return $this->threadName;
    }

    /**
     * Send the message without triggering a push/desktop notification.
     */
    public function sendSilently(): void
    {
        $this->flags[] = self::FLAG_SUPPRESS_NOTIFICATIONS;
    }

    public function withoutExpandingEmbeds(): void
    {
        $this->flags[] = self::FLAG_SUPPRESS_EMBEDS;
    }

    public function asTextToSpeech(): void
    {
        $this->tts = true;
    }

    public function isTextToSpeech(): bool
    {
        return $this->tts;
    }

    public function setAllowedMentions(AllowedMentions $allowedMentions): void
    {
        $this->allowedMentions = $allowedMentions;
    }

    public function allowedMentions(): ?AllowedMentions
    {
        return $this->allowedMentions;
    }

    public function hasAllowedMentions(): bool
    {
        return $this->allowedMentions !== null;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['content'])) {
            $this->setContent($array['content']);
        }

        if (isset($array['thread_name'])) {
            $this->createThreadWithName($array['thread_name']);
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
            'username' => $this->webhookUsername,
            'avatar_url' => $this->webhookAvatarUrl,
        ];

        if ($this->hasContent()) {
            $jsonData['content'] = $this->content;
        }

        if (isset($this->threadName)) {
            $jsonData['thread_name'] = $this->threadName;
        }

        if (count($this->flags) > 0) {
            $jsonData['flags'] = array_sum($this->flags);
        }

        if ($this->isTextToSpeech()) {
            $jsonData['tts'] = true;
        }

        if ($this->hasAllowedMentions()) {
            $jsonData['allowed_mentions'] = $this->allowedMentions->jsonSerialize();
        }

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
