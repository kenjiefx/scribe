<?php 

namespace Kenjiefx\Scribe\Cache;
use Kenjiefx\Scribe\Repository;

class CacheItem {

    public function __construct(
        private Repository $Repository
    ){

    }

    public function getNamespace(){
        $owner = $this->Repository->getOwner();
        $name  = $this->Repository->getName();
        return $owner.'/'.$name;
    }

    public function getName(){
        return $this->Repository->getName();
    }

}