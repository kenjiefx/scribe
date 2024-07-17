<?php 

namespace Kenjiefx\Scribe\Dependencies;

class DependenciesIterator implements \Iterator {
    private array $dependencies;
    private int $position;

    public function __construct(array $dependencies) {
        $this->dependencies = $dependencies;
        $this->position = 0;
    }

    public function current(): DependencyModel {
        return $this->dependencies[$this->position];
    }

    public function key():mixed {
        return $this->position;
    }

    public function next():void {
        $this->position++;
    }

    public function rewind(): void {
        $this->position = 0;
    }

    public function valid(): bool {
        return isset($this->commits[$this->position]);
    }
}