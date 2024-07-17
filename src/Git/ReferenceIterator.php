<?php 

namespace Kenjiefx\Scribe\Git;
use Kenjiefx\Scribe\Git\GitReference;

class ReferenceIterator implements \Iterator {
    private array $refs;
    private $position;

    public function __construct(array $refs) {
        $this->refs = $refs;
        $this->position = 0;
    }

    public function current(): GitReference {
        return $this->refs[$this->position];
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
        return isset($this->refs[$this->position]);
    }
}