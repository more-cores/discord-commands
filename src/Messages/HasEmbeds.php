<?php

namespace DiscordBuilder\Messages;

use DiscordBuilder\Messages\Embed\Embed;

trait HasEmbeds
{
    protected array $embeds = [];

    public function addEmbed(Embed $embed): void
    {
        $this->embeds[] = $embed;
    }

    /**
     * @return Embed[]
     */
    public function embeds(): array
    {
        return $this->embeds;
    }

    public function setEmbeds(array $embeds): void
    {
        $this->embeds[] = $embeds;
    }

    public function hasEmbeds(): bool
    {
        return count($this->embeds) > 0;
    }

    protected function hydrateEmbeds(array $array): void
    {
        foreach ($array as $embed) {
            if ($embed instanceof Embed) {
                $this->addEmbed($embed);
            } else {
                $this->addEmbed((new Embed)->hydrate($embed));
            }
        }
    }

    protected function serializeEmbeds(): array
    {
        $embeds = [];
        if ($this->hasEmbeds()) {
            foreach ($this->embeds() as $embed) {
                $embeds[] = $embed->jsonSerialize();
            }
        }

        return $embeds;
    }
}