<?php

namespace Kenjiefx\Scribe\Core\Pullers;

use Kenjiefx\Scribe\Core\Platforms\GitHubModel;
use Kenjiefx\Scribe\Core\Sources\SourceIterator;
use Kenjiefx\Scribe\Interfaces\CacheManagerInterface;

class PullService
{
    public function __construct(
        private GitHubPullService $ghPullService,
        private CacheManagerInterface $cacheManager
    ) {
    }

    public function pull(SourceIterator $sources, callable $callback): void
    {
        foreach ($sources as $source) {
            if ($source->platform instanceof GitHubModel) {
                $releaseZip = $this->ghPullService->pullSource($source->platform);
                $callback($source, $releaseZip);
            } else {
                throw new \Exception("PullService: Unsupported platform");
            }
        }
    }
}