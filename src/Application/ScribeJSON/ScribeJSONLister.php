<?php

namespace Kenjiefx\Scribe\Application\ScribeJSON;

use Kenjiefx\Scribe\Core\Packages\PackageModel;
use Kenjiefx\Scribe\Core\Platforms\GitHubModel;
use Kenjiefx\Scribe\Core\Pulls\PullIterator;
use Kenjiefx\Scribe\Core\Pulls\PullModel;
use Kenjiefx\Scribe\Core\Releases\ReleaseModel;
use Kenjiefx\Scribe\Core\Repositories\RepositoryModel;
use Kenjiefx\Scribe\Core\Sources\SourceIterator;
use Kenjiefx\Scribe\Core\Sources\SourceModel;
use Kenjiefx\Scribe\Interfaces\SourceListingInterface;

/**
 * An implementation of SourceListingInterface that uses 
 * JSON file for configuration.
 */
class ScribeJSONLister implements SourceListingInterface
{

    private static array $conf = [];
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        // check if there is constant defined ROOT 
        if (!\defined('ROOT')) {
            throw new \RuntimeException('Constant ROOT is not defined.');
        }
        if (empty(self::$conf)) {
            $configPath = \rtrim(\constant('ROOT'), '/\\') . '/scribe.json';
            if (!\file_exists($configPath)) {
                throw new \RuntimeException("Configuration file scribe.json not found in ROOT directory.");
            }
            $jsonContent = \file_get_contents($configPath);
            $decoded = \json_decode($jsonContent, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException("Error parsing scribe.json: " . json_last_error_msg());
            }
            self::$conf = $decoded;
        }
    }

    public function getSources(): SourceIterator
    {
        $this->assertConfNotEmpty();
        /**  @var SourceModel[] */
        $sources = [];
        foreach ((self::$conf['sources'] ?? []) as $name => $details) {
            $platform = $this->getPlatformModel($name, $details);
            $sources[] = new SourceModel(
                name: $name,
                platform: $platform
            );
        }
        return new SourceIterator($sources);
    }

    public function getPlatformModel(string $source, array $details): GitHubModel
    {
        $platform = $details['platform'] ?? null;
        if ($platform === null) {
            throw new \RuntimeException("Platform must be "
                . "specified for source: $source");
        }
        switch ($platform) {
            case 'github':
                $owner = $details['owner'] ?? null;
                if ($owner === null) {
                    throw new \RuntimeException("Owner must be specified for source: $source");
                }
                $repo = $details["repository"] ?? null;
                if ($repo === null) {
                    throw new \RuntimeException("Repository must be specified for source: $source");
                }
                $repository = new RepositoryModel(
                    owner: $owner,
                    name: $repo
                );
                $package = new PackageModel(
                    repository: $repository
                );
                /** @var ReleaseModel|null */
                $release = null;
                if (isset($details['release'])) {
                    $tagName = $details['release'];
                    $release = new ReleaseModel(
                        tagName: $tagName,
                        srcUrl: "https://github.com/{$owner}/{$repo}/archive/refs/tags/{$tagName}.zip"
                    );
                }
                $pullModels = $this->generatePullIterator($details['pulls'] ?? []);
                return new GitHubModel(
                    package: $package,
                    release: $release,
                    pulls: $pullModels
                );
            default:
                throw new \RuntimeException("Unsupported platform: $platform"
                    . "for source: $source");
        }
    }

    public function generatePullIterator(array $pulls): PullIterator
    {
        /** @var PullModel[] */
        $pullModels = [];
        foreach ($pulls as $sourcePath => $destinationPath) {
            $pullModels[] = new PullModel(
                from: $sourcePath,
                to: $destinationPath
            );
        }
        return new PullIterator($pullModels);
    }

    private function assertConfNotEmpty(): void
    {
        if (empty(self::$conf)) {
            throw new \RuntimeException('Configuration is not initialized,'
                . ' or scribe.json is empty, invalid, or missing.');
        }
    }
}