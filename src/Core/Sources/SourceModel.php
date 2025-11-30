<?php

namespace Kenjiefx\Scribe\Core\Sources;

use Kenjiefx\Scribe\Core\Platforms\GitHubModel;

class SourceModel
{
    public function __construct(
        public readonly string $name,
        public readonly GitHubModel $platform
    ) {
    }
}