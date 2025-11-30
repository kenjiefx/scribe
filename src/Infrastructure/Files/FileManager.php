<?php

namespace Kenjiefx\Scribe\Infrastructure\Files;

use Kenjiefx\Scribe\Interfaces\FileManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * This implementation wraps around Symfony's 
 * Filesystem component.
 */
class FileManager implements FileManagerInterface
{

    public function __construct(
        private Filesystem $filesystem
    ) {
    }

    public function makeTemporaryFile(): string
    {
        return tempnam(sys_get_temp_dir(), 'scribe_');
    }

    public function createFile(string $path, string $content): void
    {
        $this->filesystem->dumpFile($path, $content);
    }

    public function removeFile(string $path): void
    {
        $this->filesystem->remove($path);
    }
}