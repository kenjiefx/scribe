<?php

namespace Kenjiefx\Scribe\Interfaces;

/**
 * An interface for cache management operations.
 * This allows different implementations for caching,
 * such as in-memory caching, file-based caching, or external services.
 */
interface CacheManagerInterface
{

    /**
     * Checks if the cache contains the given key.
     *
     * @param string $key The cache key.
     * @return bool True if the cache contains the key, false otherwise.
     */
    public function has(string $key): bool;

    /**
     * Retrieves the cached content for the given key.
     *
     * @param string $key The cache key.
     * @return string|null The cached content, or null if not found.
     */
    public function get(string $key): ?string;

    /**
     * Stores the given content in the cache under the specified key.
     *
     * @param string $key The cache key.
     * @param string $content The content to cache.
     */
    public function set(string $key, string $content): void;
}