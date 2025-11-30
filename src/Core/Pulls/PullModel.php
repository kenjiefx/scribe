<?php

namespace Kenjiefx\Scribe\Core\Pulls;

class PullModel
{
    public function __construct(
        /**
         * Source path in the repository
         */
        public readonly string $from,
        /**
         * Destination path in the local system
         */
        public readonly string $to
    ) {
    }

    public function getFullToPath(): string
    {
        // Remove ./ from the beginning of the path if present
        $toPath = ltrim($this->to, './');
        return ROOT . '/' . ltrim($toPath, '/');
    }

    public function getRelativeFromPath(): string
    {
        return ltrim($this->from, './');
    }
}