<?php

namespace Kenjiefx\Scribe\Interfaces;

/**
 * An interface for file management operations.
 */
interface FileManagerInterface
{
    /**
     * Creates a temporary file and returns its path.
     *
     * @return string The path to the temporary file.
     */
    public function makeTemporaryFile(): string;

    /**
     * Creates a file at the specified path with the given content.
     *
     * @param string $path The path where the file will be created.
     * @param string $content The content to write to the file.
     */
    public function createFile(string $path, string $content): void;

    /**
     * Removes the file at the specified path.
     *
     * @param string $path The path of the file to remove.
     */
    public function removeFile(string $path): void;
}