<?php

namespace DiscordBuilder\Commands\Options;

use DiscordBuilder\Commands\HasCommandOptions;
use DiscordBuilder\Jsonable;

class Option extends Jsonable
{
    protected string $name = '';
    protected string $description = '';
    protected bool $required = false;

    public function __construct(
        protected int $type,
        string $name = '',
        string $description = '',
        bool $required = false,
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->required = $required;
    }

    public function type(): int
    {
        return $this->type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name = ''): void
    {
        $this->name = $name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function setDescription(string $description = ''): void
    {
        $this->description = $description;
    }

    public function isOptional(): bool
    {
        return $this->required === false;
    }

    public function isRequired(): bool
    {
        return $this->required === true;
    }

    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }

    public function jsonSerialize(): array
    {
        $data = [
            'type' => $this->type(),
            'name' => $this->name(),
            'description' => $this->description(),
            'required' => $this->isRequired(),
        ];

        $traitsUsed = class_uses($this);
        if (in_array(HasCommandOptions::class, $traitsUsed)) {
            if ($this->hasOptions()) {
                $data['options'] = [];

                foreach ($this->options() as $option) {
                    $data['options'][] = $option->jsonSerialize();
                }
            }
        }

        if (in_array(HasOptionChoices::class, $traitsUsed)) {
            $data['choices'] = $this->serializeChoices();
        }

        if (in_array(HasAutocomplete::class, $traitsUsed)) {
            $data['autocomplete'] = $this->isAutocompleteEnabled();
        }

        if (in_array(HasMinAndMaxValues::class, $traitsUsed)) {
            if ($this->hasMinValue()) {
                $data['min_value'] = $this->minValue();
            }

            if ($this->hasMaxValue()) {
                $data['max_value'] = $this->maxValue();
            }
        }

        if (in_array(HasMinAndMaxLength::class, $traitsUsed)) {
            if ($this->hasMinLength()) {
                $data['min_length'] = $this->minLength();
            }

            if ($this->hasMaxLength()) {
                $data['max_length'] = $this->maxLength();
            }
        }

        return array_filter($data);
    }
}
