<?php

namespace Kenjiefx\Scribe\Services\GitHub;

class GitHubClient
{
    protected $curlHandler;
    private string $username;
    private string $token;
    public const BASE_API = 'https://api.github.com';

    public const USER_AGENT = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';

    public function __construct()
    {
        $this->curlHandler = curl_init();
        $this->setUserAgent();
        $this->setReturnTransfer();
    }

    /**
     * Provide your GitHub username and Personal Access Token (PAT)
     * through this method
     */
    public function setCredentials(string $username, string $token): void {
        $this->username = $username;
        $this->token = $token;
        $this->setHttpAuth(1);
    }

    private function setHttpAuth(int $AuthMethod):void{
        curl_setopt($this->curlHandler,CURLOPT_HTTPAUTH,$AuthMethod);
        if ($AuthMethod===1)
            curl_setopt(
                $this->curlHandler,
                CURLOPT_USERPWD, 
                $this->username.':'.$this->token
           );
    }

    public function setUserAgent(?string $userAgent = null){
        curl_setopt(
            $this->curlHandler, 
            CURLOPT_USERAGENT, 
            $userAgent ?? 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)'
        );
    }

    public function setReturnTransfer(){
        curl_setopt(
            $this->curlHandler,
            CURLOPT_RETURNTRANSFER,
            1
        );
    }

    public function setFollowLocation(){
        curl_setopt(
            $this->curlHandler,
            CURLOPT_FOLLOWLOCATION,
            1
        );
    }

    public function setCurlFileOption($filePointer) {
        curl_setopt($this->curlHandler, CURLOPT_FILE, $filePointer);
    }


    public function __destruct(){
        curl_close($this->curlHandler);
    }

}