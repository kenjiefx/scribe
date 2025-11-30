<?php

namespace Kenjiefx\Scribe\Infrastructure\Platforms\GitHub;

use Kenjiefx\Scribe\Interfaces\GitHubClientInterface;

use Kenjiefx\Scribe\Core\Releases\ReleaseModel;

class GitHubClient implements GitHubClientInterface
{

    public function fetchByRelease(ReleaseModel $release): string
    {
        $apiClient = new GitHubAPIClient();
        $apiClient->setCredentials(
            $_ENV['GITHUB_USERNAME'],
            $_ENV['GITHUB_TOKEN']
        );
        return $apiClient->fetchRelease($release->srcUrl);
    }

}