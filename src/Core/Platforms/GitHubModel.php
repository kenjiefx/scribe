<?php

namespace Kenjiefx\Scribe\Core\Platforms;

use Kenjiefx\Scribe\Core\Pulls\PullIterator;
use Kenjiefx\Scribe\Core\Packages\PackageModel;
use Kenjiefx\Scribe\Core\Releases\ReleaseModel;

/**
 * GitHub is a code hosting platform for version control and collaboration.
 * This class represents a GitHub platform model.
 */
class GitHubModel
{
    public function __construct(
        public readonly PackageModel $package,
        public readonly ReleaseModel|null $release,
        public readonly PullIterator $pulls,
    ) {
    }
}