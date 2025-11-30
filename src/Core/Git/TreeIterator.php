<?php

namespace Kenjiefx\Scribe\Core\Git;
use Kenjiefx\Scribe\Core\Git\GitTree;

class TreeIterator implements \Iterator
{
    private array $trees;
    private int $position;

    public function __construct(array $trees)
    {
        $this->trees = $trees;
        $this->position = 0;
    }

    public function current(): GitTree
    {
        return $this->trees[$this->position];
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
        return isset($this->trees[$this->position]);
    }
}