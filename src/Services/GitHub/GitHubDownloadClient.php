<?php

namespace Kenjiefx\Scribe\Services\GitHub;
use Kenjiefx\Scribe\Repository;
use Kenjiefx\Scribe\Services\GitHub\GitHubClient;

class GitHubDownloadClient extends GitHubClient {

    public function commit($filePointer, string $url): void {
        $this->setCurlFileOption($filePointer);
        $this->setFollowLocation();
        curl_setopt($this->curlHandler, CURLOPT_URL, $url);
        curl_exec($this->curlHandler);
        curl_close($this->curlHandler);
    }

}