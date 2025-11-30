<?php

namespace Kenjiefx\Scribe\Application\UseCases;

use Kenjiefx\Scribe\Core\Extractors\ExtractService;
use Kenjiefx\Scribe\Core\Pullers\PullService;
use Kenjiefx\Scribe\Core\Pulls\PullMapper;
use Kenjiefx\Scribe\Core\Pulls\PullModel;
use Kenjiefx\Scribe\Core\Sources\SourceIterator;
use Kenjiefx\Scribe\Core\Sources\SourceModel;
use Kenjiefx\Scribe\Interfaces\FileManagerInterface;

class PullUseCase
{
    public function __construct(
        private PullService $pullService,
        private PullMapper $pullMapper,
        private FileManagerInterface $fileManager
    ) {

    }

    public function execute(SourceIterator $sources): void
    {
        $pullMapper = $this->pullMapper;
        $this->pullService->pull($sources, function (SourceModel $source, string $file) use ($sources, $pullMapper) {
            $pullMapper->map($source, $file, function (PullModel $pull, string $content) {
                $this->fileManager->createFile($pull->getFullToPath(), $content);
            });
        });
    }
}