<?php

namespace Kenjiefx\Scribe\Core\Pulls;

use Kenjiefx\Scribe\Core\Platforms\GitHubModel;
use Kenjiefx\Scribe\Core\Sources\SourceModel;
use Kenjiefx\Scribe\Interfaces\FileManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

class GitHubPullMapper
{
    public function __construct(
        private FileManagerInterface $filesystem,
        private ZipFileService $zipFileService
    ) {

    }

    public function map(GitHubModel $github, string $content, callable $callback)
    {
        /** @var PullModel[] */
        $newPulls = [];

        // We need to adjust the 'from' paths to include the root folder in the ZIP
        // GitHub ZIPs typically have a root folder named as "repository-tagname"
        // So we prepend that to each 'from' path
        foreach ($github->pulls as $pull) {
            $ghfolder = $this->toFolderName($github);
            $fullFrom = $pull->getRelativeFromPath();
            $newFrom = "$ghfolder/$fullFrom";
            $newPulls[] = new PullModel(
                from: $newFrom,
                to: $pull->to
            );
        }
        $this->zipFileService->processPulls($newPulls, $content, $callback);
    }

    /**
     * Converts GitHubModel to a folder name used in the ZIP archive.
     * @param GitHubModel $github
     * @return string
     */
    private function toFolderName(GitHubModel $github): string
    {
        $repository = $github->package->repository->name;
        $tagName = $github->release->tagName;
        // Strip leading 'v' only if followed by a digit
        if (preg_match('/^v\d/', $tagName)) {
            $tagName = substr($tagName, 1);
        }
        return "$repository-$tagName";
    }
}