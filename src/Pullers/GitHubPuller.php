<?php 

namespace Kenjiefx\Scribe\Pullers;
use Kenjiefx\Scribe\Cache\CacheItem;
use Kenjiefx\Scribe\Cache\CacheManager;
use Kenjiefx\Scribe\Config\EnvHelper;
use Kenjiefx\Scribe\Dependencies\DependencyModel;
use Kenjiefx\Scribe\Services\GitHub\GitHubAPIClient;
use Kenjiefx\Scribe\Services\GitHub\GitHubService;

class GitHubPuller extends BasePuller {

    public function __construct(
        private DependencyModel $DependencyModel
    ){

    }

    public function pull(){
        $repository = $this->DependencyModel->getRepository();
        $owner = $repository->getOwner();
        $name  = $repository->getName();
        echo 'Pulling repository github:'.$owner.'/'.$name.PHP_EOL;
        $github = new GitHubService(
            new EnvHelper(),
            new GitHubAPIClient()
        );
        $latestCommit = $github->getMainBranchLatestCommit($repository);
        $sha = $latestCommit->getSha();
        $cache = new CacheManager(
            new CacheItem(
                $this->DependencyModel->getRepository()
            )
        );
        if (
            $cache->getCachedSha() === null || 
            $cache->getCachedSha() !== $sha
        ) {
            $tempFile = $this->getTempFile();
            $downloadFile = fopen($tempFile,'w+');
            $github->downloadRepositoryByCommit(
                $downloadFile,
                $repository,
                $latestCommit
            );
            fclose($downloadFile);
            $cache->storeZip($sha, $tempFile);
        }
    }



}