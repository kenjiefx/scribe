<?php

namespace Kenjiefx\Scribe\Core\Pulls;

use Kenjiefx\Scribe\Interfaces\FileManagerInterface;

class ZipFileService
{
    public function __construct(
        private FileManagerInterface $filesystem
    ) {
    }

    /**
     * Processes pulls from the given ZIP content.
     * @param PullModel[] $pulls - An array of PullModel
     * @param string $content - ZIP file content
     * @param callable $callback - A callback function to handle each extracted file
     * @return void
     */
    public function processPulls(array $pulls, string $content, callable $callback)
    {
        $zipArchive = new \ZipArchive();
        $tmpFile = $this->filesystem->makeTemporaryFile();
        $this->filesystem->createFile($tmpFile, $content);

        if ($zipArchive->open($tmpFile) === true) {
            foreach ($pulls as $pull) {

                $pullFromPath = $pull->getRelativeFromPath();
                echo "Extracting $pullFromPath...\n";

                // Try to locate the exact entry
                $idx = $zipArchive->locateName($pullFromPath, \ZipArchive::FL_NOCASE);

                if ($idx !== false) {

                    // It's a directory if ZIP entry ends with /
                    if (str_ends_with($zipArchive->getNameIndex($idx), '/')) {
                        // Directory extraction
                        $this->processDirectory($zipArchive, $pullFromPath, $pull, $callback);
                    } else {
                        // Single file extraction
                        $fileContent = $zipArchive->getFromIndex($idx);
                        $callback($pull, $fileContent);
                    }

                    continue;

                }

                $foundAny = false;

                // If not found as exact entry, check if it's a directory by scanning entries
                for ($i = 0; $i < $zipArchive->numFiles; $i++) {
                    $entry = $zipArchive->getNameIndex($i);
                    if (str_starts_with($entry, $pullFromPath . '/')) {
                        $foundAny = true;
                        break;
                    }
                }

                if ($foundAny) {
                    // Directory extraction
                    $this->processDirectory($zipArchive, $pullFromPath, $pull, $callback);
                    continue;
                }

                echo "[Warning] Not found in ZIP: $pullFromPath\n";
            }

            $zipArchive->close();

        }

        $this->filesystem->removeFile($tmpFile);

    }

    private function processDirectory(
        \ZipArchive $zipArchive,
        string $dirPath,
        PullModel $pull,
        callable $callback
    ): void {
        for ($i = 0; $i < $zipArchive->numFiles; $i++) {
            $entry = $zipArchive->getNameIndex($i);
            if (str_starts_with($entry, $dirPath) && !str_ends_with($entry, '/')) {
                $fileContent = $zipArchive->getFromName($entry);
                $relative = substr($entry, strlen($dirPath));
                $pullModel = new PullModel(
                    from: $relative,
                    to: $pull->to . '/' . $relative
                );
                $callback($pullModel, $fileContent);
            }
        }
    }
}