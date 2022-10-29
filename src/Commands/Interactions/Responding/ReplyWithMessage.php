<?php

namespace DiscordBuilder\Commands\Interactions\Responding;

use DiscordBuilder\Jsonable;
use DiscordBuilder\Messages\Components\Component;
use DiscordBuilder\Messages\Components\HasComponents;
use DiscordBuilder\Messages\Embed\Embed;
use DiscordBuilder\Messages\HasEmbeds;

class ReplyWithMessage extends Jsonable implements CommandResponse
{
    public const TYPE = 4;

    public const FLAG_SUPPRESS_EMBEDS = 0x0000000000000004;
    public const FLAG_EPHEMERAL = 0x0000000000000040;

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
        bool $withoutExpandingEmbeds = null,
        bool $onlyVisibleToCommandIssuer = null,
    ) {
        $this->content = $content;
        $this->embeds = $embeds;
        $this->components = $components;

        if ($withoutExpandingEmbeds !== null) {
            $this->withoutExpandingEmbeds();
        }
        if ($onlyVisibleToCommandIssuer !== null) {
            $this->onlyVisibleToCommandIssuer();
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

    public function withoutExpandingEmbeds(): void
    {
        $this->flags[] = self::FLAG_SUPPRESS_EMBEDS;
    }

    public function onlyVisibleToCommandIssuer(): void
    {
        $this->flags[] = self::FLAG_EPHEMERAL;
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