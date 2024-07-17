<?php 

namespace Kenjiefx\Scribe\Services\GitHub;
use Kenjiefx\Scribe\Config\EnvHelper;
use Kenjiefx\Scribe\Exceptions\BranchNotFoundException;
use Kenjiefx\Scribe\Exceptions\GitHubNotFoundException;
use Kenjiefx\Scribe\Git\CommitHistoryIterator;
use Kenjiefx\Scribe\Git\GitCommit;
use Kenjiefx\Scribe\Git\GitReference;
use Kenjiefx\Scribe\Git\GitTree;
use Kenjiefx\Scribe\Git\ReferenceIterator;
use Kenjiefx\Scribe\Git\TreeIterator;
use Kenjiefx\Scribe\Interfaces\RemoteHostInterface;
use Kenjiefx\Scribe\Release;
use Kenjiefx\Scribe\Repository;

class GitHubService implements RemoteHostInterface {

    public function __construct(
        private EnvHelper $EnvHelper,
        private GitHubAPIClient $APIClient
    ){
        $this->APIClient->setCredentials(
            username: $this->EnvHelper->getEnvar('GITHUB_USERNAME'),
            token: $this->EnvHelper->getEnvar('GITHUB_ACCESS_TOKEN'),
        );
    }

    public function getCurrentRelease(Repository $repository): Release{
        $namespace = $this->getNamespace($repository);
        $url = sprintf(
            '/repos/%s/releases/latest', 
            $namespace
        );
        $response = $this->APIClient->get($url);
        if (isset($response['message'])) { 
            throw new GitHubNotFoundException($namespace);
        }
        $release = new Release();
        $release->setTagName($response['tag_name'])
                ->setSrcUrl($response['tarball_url']);
        return $release;
    }

    public function getReleaseByTag(Repository $repository, string $tagName):Release {
        $namespace = $this->getNamespace($repository);
        $url = sprintf(
            '/repos/%s/releases/tags/%s', 
            $namespace,
            $tagName
        );
        $response = $this->APIClient->get($url);
        if (isset($response['message'])) { 
            throw new GitHubNotFoundException($namespace);
        }
        $release = new Release();
        $release->setTagName($response['tag_name'])
                ->setSrcUrl($response['tarball_url']);
        return $release;
    }

    /**
     * Retrieves the main/master branch with the latest
     * commit of that branch
     */
    public function getMainBranchLatestCommit(Repository $repository): GitCommit {
        $references = $this->getRefs($repository);
        foreach ($references as $reference) {
            $ref = $reference->getRef();
            if ($ref==='refs/heads/main') {
                $commit = $reference->getCommit();
                return $commit;
            }
        }
        throw new BranchNotFoundException('main', $repository);
    }

    public function getRefs(Repository $repository): ReferenceIterator {
        $namespace = $this->getNamespace($repository);
        $url = sprintf(
            '/repos/%s/git/refs', 
            $namespace
        );
        $response = $this->APIClient->get($url);
        $references = [];
        foreach ($response as $data) {
            $reference = new GitReference();
            $reference->setRef($data['ref'])
                      ->setNodeId($data['node_id'])
                      ->setUrl($data['url']);
            $object = $data['object'];
            $commit = new GitCommit();
            $commit->setSha($object['sha'])
                    ->setUrl($object['url']);
            $reference->setCommit($commit);
            array_push($references, $reference);
        }
        return new ReferenceIterator($references);
    }

    public function getTree(Repository $repository, GitCommit $commit): TreeIterator{
        $sha = $commit->getSha();
        $namespace = $this->getNamespace($repository);
        $url = sprintf(
            '/repos/%s/git/trees/%s', 
            $namespace,
            $sha
        );
        $response = $this->APIClient->get($url);
        $trees = [];
        foreach ($response['tree'] as $data) {
            $tree = new GitTree();
            $tree->setPath($data['path'])
                 ->setSha($data['sha'])
                 ->setUrl($data['url'])
                 ->setType($data['type']);
            array_push($trees, $tree);
        }
        return new TreeIterator($trees);
    }

    private function getNamespace(Repository $repository): string {
        $owner = $repository->getOwner();
        $name = $repository->getName();
        return $owner.'/'.$name;
    }

    public function downloadRepositoryByCommit($filePointer, Repository $repository, GitCommit $commit): void {
        $DownloadClient = new GitHubDownloadClient();
        $DownloadClient->setCredentials(
            username: $this->EnvHelper->getEnvar('GITHUB_USERNAME'),
            token: $this->EnvHelper->getEnvar('GITHUB_ACCESS_TOKEN'),
        );
        $sha = $commit->getSha();
        $namespace = $this->getNamespace($repository);
        $url = sprintf(
            'https://github.com/%s/archive/%s.zip', 
            $namespace,
            $sha
        );
        $DownloadClient->commit($filePointer, $url);
    }

}