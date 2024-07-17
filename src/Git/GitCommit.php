<?php 

namespace Kenjiefx\Scribe\Git;

class GitCommit {
    private string $sha;

    private string $url;

    public function __construct(){

    }

    public function setSha(string $sha): GitCommit{
        $this->sha = $sha;
        return $this;
    }

    public function getSha(): string{
        return $this->sha;
    }

    public function setUrl(string $url): GitCommit{
        $this->url = $url;
        return $this;
    }

    public function getUrl(): string{
        return $this->url;
    }
}