<?php

namespace Kenjiefx\Scribe\Core\Git;

class GitTree
{

    private string $path;

    private string $type;

    private string $sha;

    private string $url;

    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setSha(string $sha): self
    {
        $this->sha = $sha;
        return $this;
    }

    public function getSha(): string
    {
        return $this->sha;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }


}