<?php

namespace Kenjiefx\Scribe\Infrastructure\Cache;

use Kenjiefx\Scribe\Interfaces\CacheManagerInterface;

/**
 * A simple local file-based cache manager. This implementation
 * caches data in the user's home directory under a .scribe.cache folder.
 */
class LocalCacheService implements CacheManagerInterface
{

    public function __construct()
    {
    }

    public function has(string $key): bool
    {
        $cacheFilePath = $this->createCacheFilePath($key);
        return file_exists($cacheFilePath);
    }

    public function get(string $key): ?string
    {
        $cacheFilePath = $this->createCacheFilePath($key);
        if (file_exists($cacheFilePath)) {
            return file_get_contents($cacheFilePath) ?: null;
        }
        return null;
    }

    public function set(string $key, string $content): void
    {
        $cacheFilePath = $this->createCacheFilePath($key);
        $cacheDir = dirname($cacheFilePath);

        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        file_put_contents($cacheFilePath, $content);
    }

    private function createCacheFilePath(string $key): string
    {
        $homeDir = $this->getHomeDir();
        $cacheDir = $homeDir . DIRECTORY_SEPARATOR . '.scribe.cache';
        return $cacheDir . DIRECTORY_SEPARATOR . $key;
    }

    private function getHomeDir(): string
    {
        // Unix / macOS
        if ($home = getenv('HOME')) {
            return rtrim($home, DIRECTORY_SEPARATOR);
        }

        // Windows
        if ($home = getenv('USERPROFILE')) {
            return rtrim($home, DIRECTORY_SEPARATOR);
        }

        // Windows fallback
        if ($homeDrive = getenv('HOMEDRIVE') && $homePath = getenv('HOMEPATH')) {
            return rtrim($homeDrive . $homePath, DIRECTORY_SEPARATOR);
        }

        throw new \RuntimeException('Local cache service: unable to determine the home directory.');
    }
}