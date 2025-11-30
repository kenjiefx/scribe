<?php

namespace Kenjiefx\Scribe\Core\Pullers;
use Kenjiefx\Scribe\Core\Platforms\GitHubModel;
use Kenjiefx\Scribe\Core\Sources\SourceModel;
use Kenjiefx\Scribe\Interfaces\CacheManagerInterface;
use Kenjiefx\Scribe\Interfaces\GitHubClientInterface;

class GitHubPullService
{

    public function __construct(
        private GitHubClientInterface $client,
        private CacheManagerInterface $cache
    ) {
    }

    public function pullSource(GitHubModel $github)
    {
        $cache = $this->retrieveFromCache($github);
        if ($cache !== null) {
            return $cache;
        }
        $release = $github->release;
        return $this->client->fetchByRelease($release);
    }

    /**
     * Attempts to retrieve a cached release based on the source's repository owner, name, and release tag name.
     * @param GitHubModel $github
     * @return string|null The cached package if found, otherwise null.
     */
    private function retrieveFromCache(GitHubModel $github): string|null
    {
        [$owner, $name, $tagName] = $this->getDetails($github);
        $cacheKey = $this->getCacheKey($github);
        if ($this->cache->has($cacheKey)) {
            echo "Using cached package: {$owner}/{$name} ({$tagName})\n";
            return $this->cache->get($cacheKey);
        }
        return null;
    }

    /**
     * Creates a cache key based on the source's repository owner, name, and release tag name.
     * @param SourceModel $source
     * @return string
     */
    public function getCacheKey(GitHubModel $github): string
    {
        [$owner, $name, $tagName] = $this->getDetails($github);
        return md5("$owner/$name@$tagName");
    }

    private function getDetails(GitHubModel $github): array
    {
        $owner = $github->package->repository->owner;
        $name = $github->package->repository->name;
        $tagName = $github->release->tagName;
        return [$owner, $name, $tagName];
    }

}