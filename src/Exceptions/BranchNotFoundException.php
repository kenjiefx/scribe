<?php 

namespace Kenjiefx\Scribe\Exceptions;
use Kenjiefx\Scribe\Repository;
class BranchNotFoundException extends \Exception {

    public function __construct(string $branch, Repository $repository){
        $owner = $repository->getOwner();
        $name = $repository->getName();
        $namespace = $owner.'/'.$name;
        $message = sprintf('Failed to retrieve "/%s/" branch from repository "/%s/", branch not existing. ', $branch, $namespace);
        parent::__construct($message,1);
    }

}