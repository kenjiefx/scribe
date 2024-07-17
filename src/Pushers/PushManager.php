<?php 

namespace Kenjiefx\Scribe\Pushers;
use Kenjiefx\Scribe\Cache\CacheItem;
use Kenjiefx\Scribe\Cache\CacheManager;
use Kenjiefx\Scribe\Dependencies\DependencyModel;
use Kenjiefx\Scribe\Repository;

class PushManager {

    public function __construct(
        private DependencyModel $DependencyModel
    ){

    }

    public function push(){
        $dependency = $this->DependencyModel;
        $repository = $dependency->getRepository();
        $package = $repository->getPackageName();

        $cache = new CacheManager(
            new CacheItem($repository)
        );

        $pulls = $dependency->getPulls();
        foreach ($pulls as $source => $destination) {

            $source_path = $cache->getPath($source);
            
            if (!is_dir($source_path) && !file_exists($source_path)){
                echo '[WARNING] file not found in this repository '.$package.': '.$source;
                continue;
            }

            $chars = str_split($destination);
            if ($chars[0] === '.') {
                $destination = ROOT.substr($destination, 1);
            }

            if (is_dir($source_path)) {
                $this->copydir($source_path, $destination);
                continue;
            }

            $this->copyfile($source_path, $destination);

        }
    }

    private function copydir(string|null $sourcedir, string $destdir){
        $files = scandir($sourcedir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            $path = $sourcedir . '/' . $file;
            if (is_dir($path)) {
                $this->copydir($path, $destdir . '/' . $file);
            } else {
                $this->copyfile($path, $destdir . '/' .$file);
            }
        }
    }

    private function copyfile(string $sourceFile, string $destFile) {
        echo 'Pushing file to path: '.$destFile.PHP_EOL;
        $filedir = dirname($destFile);
        if (!is_dir($filedir)) mkdir($filedir, 0777, true);
        copy($sourceFile, $destFile);
    }

}