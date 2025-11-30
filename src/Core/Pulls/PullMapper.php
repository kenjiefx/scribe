<?php

namespace Kenjiefx\Scribe\Core\Pulls;

use Kenjiefx\Scribe\Core\Platforms\GitHubModel;
use Kenjiefx\Scribe\Core\Sources\SourceModel;

class PullMapper
{

    public function __construct(
        private GitHubPullMapper $gitHubPullMapper,
    ) {
    }

    public function map(SourceModel $source, string $content, callable $callback)
    {
        if ($source->platform instanceof GitHubModel) {
            $this->gitHubPullMapper->map($source->platform, $content, $callback);
        } else {
            throw new \Exception("PullMapService: Unsupported platform");
        }
    }


}