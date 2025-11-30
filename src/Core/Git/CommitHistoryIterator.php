<?php

namespace Kenjiefx\Scribe\Core\Git;
use Kenjiefx\Scribe\Core\Git\GitCommit;

class CommitHistoryIterator implements \Iterator
{
    private array $commits;
    private int $position;

    public function __construct(array $commits)
    {
        $this->commits = $commits;
        $this->position = 0;
    }

    public function current(): GitCommit
    {
        return $this->commits[$this->position];
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
        return isset($this->commits[$this->position]);
    }
}