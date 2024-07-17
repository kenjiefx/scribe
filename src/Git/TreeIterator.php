<?php 

namespace Kenjiefx\Scribe\Git;
use Kenjiefx\Scribe\Git\GitTree;

class TreeIterator implements \Iterator {
    private array $trees;
    private int $position;

    public function __construct(array $trees) {
        $this->trees = $trees;
        $this->position = 0;
    }

    public function current(): GitTree {
        return $this->trees[$this->position];
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
        return isset($this->trees[$this->position]);
    }
}