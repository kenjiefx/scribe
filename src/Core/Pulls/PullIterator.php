<?php

namespace Kenjiefx\Scribe\Core\Pulls;

class PullIterator implements \Iterator
{
    /** @var PullModel[] */
    private array $pulls = [];
    private int $position = 0;

    public function __construct(array $pulls)
    {
        $this->pulls = $pulls;
        $this->position = 0;
    }

    public function current(): PullModel
    {
        return $this->pulls[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->pulls[$this->position]);
    }
}