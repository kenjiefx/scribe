<?php

namespace Kenjiefx\Scribe\Core\Git;
use Kenjiefx\Scribe\Core\Git\GitReference;

class ReferenceIterator implements \Iterator
{
    private array $refs;
    private $position;

    public function __construct(array $refs)
    {
        $this->refs = $refs;
        $this->position = 0;
    }

    public function current(): GitReference
    {
        return $this->refs[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->refs[$this->position]);
    }
}