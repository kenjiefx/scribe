<?php 

namespace Kenjiefx\Scribe\Services\GitHub;
use Kenjiefx\Scribe\Services\GitHub\GitHubClient;

class GitHubAPIClient extends GitHubClient {
    
    public function get(string $url): array {
        curl_setopt(
            $this->curlHandler,
            CURLOPT_URL,
            GitHubClient::BASE_API.$url
        );
        $response = curl_exec($this->curlHandler);
        return json_decode($response,TRUE);
    }

}