<?php 

namespace Kenjiefx\Scribe;

class Repository {

    private string $owner;

    private string $name;

    /**
     * Sets the owner of the repository
     */
    public function setOwner(string $owner): Repository {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Gets the owner of the repository
     */
    public function getOwner(): string {
        return $this->owner;
    }

    /**
     * Sets the name of the repository
     */
    public function setName(string $name): Repository {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets the name of the repository
     */
    public function getName(): string {
        return $this->name;
    }

    public function getPackageName(): string {
        return $this->owner.'/'.$this->name;
    }

}