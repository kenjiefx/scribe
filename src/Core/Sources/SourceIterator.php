<?php

namespace Kenjiefx\Scribe\Core\Sources;

use Kenjiefx\Scribe\Core\Sources\SourceModel;

class SourceIterator implements \Iterator
{
    private array $sources = [];
    private int $position = 0;

    public function __construct(array $sources)
    {
        $this->sources = array_values($sources);
        $this->position = 0;
    }

    public function current(): SourceModel
    {
        return $this->sources[$this->position];
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
        return isset($this->sources[$this->position]);
    }
}