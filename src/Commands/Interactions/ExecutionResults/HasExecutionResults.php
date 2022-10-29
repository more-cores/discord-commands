<?php

namespace DiscordBuilder\Commands\Interactions\ExecutionResults;

trait HasExecutionResults
{
    protected ?CommandResults $data = null;

    public function hasData(): bool
    {
        return $this->data !== null;
    }

    public function data(): CommandResults
    {
        return $this->data;
    }

    public function hydrateExecutionResults(array $data): void
    {
        $this->data = (new CommandResults())->hydrate($data);
    }
}