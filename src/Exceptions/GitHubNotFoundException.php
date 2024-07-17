<?php 

namespace Kenjiefx\Scribe\Exceptions;

class GitHubNotFoundException extends \Exception {

    public function __construct(string $url){
        $message = sprintf('Failed to retrieve repository info from "/%s/"', $url);
        parent::__construct($message,1);
    }

}