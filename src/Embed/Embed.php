<?php

namespace DiscordBuilder\Embed;

use DateTime;
use DateTimeInterface;
use DiscordBuilder\Hydrateable;
use DiscordBuilder\Jsonable;

class Embed extends Jsonable implements Hydrateable
{
    protected ?string $title;
    protected ?string $description;
    protected ?string $url;
    protected ?string $imageUrl;
    protected ?string $thumbnailUrl;
    protected ?string $color;
    protected ?DateTimeInterface $timestamp;
    protected ?Footer $footer;
    protected ?Author $author;
    protected array $fields = [];

    public function __construct(
        ?string            $title = null,
        ?string            $description = null,
        ?string            $url = null,
        ?string            $imageUrl = null,
        ?string            $thumbnailUrl = null,
        ?string            $color = null,
        ?DateTimeInterface $timestamp = null,
        ?Footer            $footer = null,
        ?Author            $author = null,
        array              $fields = [],
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->imageUrl = $imageUrl;
        $this->thumbnailUrl = $thumbnailUrl;
        $this->color = $color;
        $this->timestamp = $timestamp;
        $this->footer = $footer;
        $this->author = $author;
        $this->fields = $fields;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function hasTitle(): bool
    {
        return $this->title !== null;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function hasDescription(): bool
    {
        return $this->description != null;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function hasUrl(): bool
    {
        return $this->url != null;
    }

    public function setTimestamp(DateTimeInterface $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function timestamp(): DateTimeInterface
    {
        return $this->timestamp;
    }

    public function hasTimestamp(): bool
    {
        return $this->timestamp != null;
    }

    public function setColorRGB(int $red, int $green, int $blue): void
    {
        $this->color = ($red << 16) + ($green << 8) + $blue;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function color(): string
    {
        return $this->color;
    }

    public function hasColor(): bool
    {
        return $this->color != null;
    }

    public function setAuthor($author, string $url = null, string $iconUrl = null): void
    {
        if ($author instanceof Author) {
            $this->author = $author;
        } else {
            $authorObject = new Author();
            $authorObject->setName($author);

            if ($url != null) {
                $authorObject->setUrl($url);
            }

            if ($iconUrl != null) {
                $authorObject->setIconUrl($iconUrl);
            }

            $this->author = $authorObject;
        }
    }

    public function author(): Author
    {
        return $this->author;
    }

    public function hasAuthor(): bool
    {
        return $this->author != null;
    }

    public function addField($field, string $value = null, bool $inline = null): void
    {
        if ($field instanceof Field) {
            $this->fields[] = $field;
        } else {
            $fieldObject = new Field();
            $fieldObject->setName($field);

            if ($value != null) {
                $fieldObject->setValue($value);
            }

            if ($inline != null && $inline === true) {
                $fieldObject->inline();
            }

            $this->fields[] = $fieldObject;
        }
    }

    public function fields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    public function hasFields(): bool
    {
        return count($this->fields) > 0;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function imageUrl(): string
    {
        return $this->imageUrl;
    }

    public function hasImage(): bool
    {
        return $this->imageUrl != null;
    }

    public function setThumbnailUrl(string $thumbnailUrl)
    {
        $this->thumbnailUrl = $thumbnailUrl;
    }

    public function thumbnailUrl(): string
    {
        return $this->thumbnailUrl;
    }

    public function hasThumbnail(): bool
    {
        return $this->thumbnailUrl != null;
    }

    public function setFooter($text, string $iconUrl = null)
    {
        if ($text instanceof Footer) {
            $this->footer = $text;
        } else {
            $footerObject = new Footer();
            $footerObject->setText($text);

            if ($iconUrl != null) {
                $footerObject->setIconUrl($iconUrl);
            }

            $this->footer = $footerObject;
        }
    }

    public function footer(): Footer
    {
        return $this->footer;
    }

    public function hasFooter(): bool
    {
        return $this->footer != null;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['title'])) {
            $this->setTitle($array['title']);
        }

        if (isset($array['description'])) {
            $this->setDescription($array['description']);
        }

        if (isset($array['url'])) {
            $this->setUrl($array['url']);
        }

        if (isset($array['timestamp'])) {
            if ($array['timestamp'] instanceof DateTime) {
                $this->setTimestamp($array['timestamp']);
            } else {
                $this->setTimestamp(new DateTime($array['timestamp']));
            }
        }

        if (isset($array['color'])) {
            $this->setColor($array['color']);
        }

        if (isset($array['footer'])) {
            if ($array['footer'] instanceof Footer) {
                $this->setFooter($array['footer']);
            } else {
                $this->setFooter((new Footer)->hydrate($array['footer']));
            }
        }

        if (isset($array['image']['url'])) {
            $this->imageUrl = $array['image']['url'];
        }

        if (isset($array['thumbnail']['url'])) {
            $this->thumbnailUrl = $array['thumbnail']['url'];
        }

        if (isset($array['author'])) {
            if ($array['author'] instanceof Author) {
                $this->setAuthor($array['author']);
            } else {
                $this->setAuthor((new Author)->hydrate($array['author']));
            }
        }

        if (isset($array['fields'])) {
            foreach ($array['fields'] as $field) {
                if ($field instanceof Field) {
                    $this->addField($field);
                } else {
                    $this->addField((new Field)->hydrate($field));
                }
            }
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->hasTitle()) {
            $data['title'] = $this->title;
        }

        if ($this->hasUrl()) {
            $data['url'] = $this->url;
        }

        if ($this->hasDescription()) {
            $data['description'] = $this->description;
        }

        if ($this->hasTimestamp()) {
            $data['timestamp'] = $this->timestamp->format(DateTime::ATOM);
        }

        if ($this->hasColor()) {
            $data['color'] = $this->color;
        }

        if ($this->hasAuthor()) {
            $data['author'] = $this->author()->jsonSerialize();
        }

        if ($this->hasThumbnail() != null) {
            $data['thumbnail'] = [
                'url' => $this->thumbnailUrl(),
            ];
        }

        if ($this->hasImage() != null) {
            $data['image'] = [
                'url' => $this->imageUrl(),
            ];
        }

        if ($this->hasFields()) {
            $data['fields'] = [];

            foreach ($this->fields() as $field) {
                $data['fields'][] = $field->jsonSerialize();
            }
        }

        if ($this->footer != null) {
            $data['footer'] = $this->footer()->jsonSerialize();
        }

        return $data;
    }
}
