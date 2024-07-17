<?php 

namespace Kenjiefx\Scribe\Git;

class GitReference {
    private string $ref;

    private string $nodeId;

    private string $url;

    private GitCommit $commit;

    public function __construct(){

    }

    public function getRef(): string { 
        return $this->ref; 
    }

    public function setRef(string $ref): GitReference {
        $this->ref = $ref;
        return $this;
    }

    public function getNodeId(): string {
        return $this->nodeId;
    }

    public function setNodeId(string $nodeId): GitReference {
        $this->nodeId = $nodeId;
        return $this;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function setUrl(string $url): GitReference {
        $this->url = $url;
        return $this;
    }

    public function getCommit() : GitCommit {
        return $this->commit;
    }

    public function setCommit(GitCommit $commit): void {
        $this->commit = $commit;
    }

    
}