<?php

namespace Kenjiefx\Scribe;

/** 
 * To change the container provider, you can modify this class.
 */
use Kenjiefx\Scribe\Interfaces\CacheManagerInterface;
use Kenjiefx\Scribe\Interfaces\FileManagerInterface;
use Kenjiefx\Scribe\Interfaces\GitHubClientInterface;
use Kenjiefx\Scribe\Interfaces\SourceListingInterface;
use League\Container\Container as ContainerProvider;

/**
 * Class responsible for binding services to the container.
 */
class Bindings
{

    public function __construct(
        private ContainerProvider $containerProvider
    ) {
    }

    public function SourceListingInterface(SourceListingInterface $configuration): void
    {
        $this->containerProvider->add(SourceListingInterface::class, $configuration);
    }

    public function GitHubClientInterface(GitHubClientInterface $client): void
    {
        $this->containerProvider->add(GitHubClientInterface::class, $client);
    }

    public function CacheManagerInterface(CacheManagerInterface $cacheManager): void
    {
        $this->containerProvider->add(CacheManagerInterface::class, $cacheManager);
    }

    public function FileManagerInterface(FileManagerInterface $fileManager): void
    {
        $this->containerProvider->add(FileManagerInterface::class, $fileManager);
    }

}