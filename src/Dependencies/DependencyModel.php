<?php 

namespace Kenjiefx\Scribe\Dependencies;
use Kenjiefx\Scribe\Repository;

class DependencyModel {

    private Repository $repository;
    private array $pulls;
    private string $source;

    public function __construct(){

    }

    public function setRepository(Repository $repository){
        $this->repository = $repository;
        return $this;
    }

    public function setPulls(array $pulls){
        $this->pulls = $pulls;
        return $this;
    }

    public function setSource(string $source){
        $this->source = $source;
        return $this;
    }

    public function getRepository(){
        return $this->repository;
    }


    public function getPulls(){
        return $this->pulls;
    }

    public function getSource(){
        return $this->source;
    }

}