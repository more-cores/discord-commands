<?php

namespace DiscordCommands\Commands\Interactions\Types;

use DiscordCommands\Commands\Interactions\Interaction;
use DiscordCommands\Commands\Interactions\ModalSubmission\SubmittedModal;

class ModalSubmitted extends Interaction
{
    public const TYPE = 5;

    protected ?SubmittedModal $data = null;

    public function __construct() {
        parent::__construct(
            type: self::TYPE,
        );
    }

    public function hasModal(): bool
    {
        return $this->data !== null;
    }

    public function modal(): SubmittedModal
    {
        return $this->data;
    }

    public function hydrate(array $array): self
    {
        if (isset($array['data'])) {
            $this->data = (new SubmittedModal())->hydrate($array['data']);
        }

        return parent::hydrate($array);
    }
}