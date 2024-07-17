<?php 

namespace Kenjiefx\Scribe\Git;
use Kenjiefx\Scribe\Git\GitCommit;

class CommitHistoryIterator implements \Iterator {
    private array $commits;
    private int $position;

    public function __construct(array $commits) {
        $this->commits = $commits;
        $this->position = 0;
    }

    public function current(): GitCommit {
        return $this->commits[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        $this->position++;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid() {
        return isset($this->commits[$this->position]);
    }
}