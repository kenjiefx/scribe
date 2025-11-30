<?php

namespace Kenjiefx\Scribe\Interfaces;

use Kenjiefx\Scribe\Core\Releases\ReleaseModel;

/**
 * An interface for implementing GitHub client.
 */
interface GitHubClientInterface
{
    /**
     * Fetches the release ZIP content for the given release.
     *
     * @param ReleaseModel $release The release model containing release information.
     * @return string The content of the release ZIP file.
     */
    public function fetchByRelease(ReleaseModel $release): string;

}