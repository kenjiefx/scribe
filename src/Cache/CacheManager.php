<?php 

namespace Kenjiefx\Scribe\Cache;

class CacheManager {

    private string $path;

    public function __construct(
        private CacheItem $CacheItem
    ){
        $this->path = __dir__.'/.cache/' . $this->CacheItem->getNamespace();
    }

    public function doesExist(){
        return is_dir($this->path);
    }

    public function getCachedSha(): string | null{
        $path = $this->path.'/sha.txt';
        if (!file_exists($path)) {
            return null;
        }
        return file_get_contents($path);
    }

    public function storeZip(string $sha, string $source){
        echo 'Extracting repository sha:'.$sha.PHP_EOL;
        $this->createDir();
        $this->setSha($sha);
        $zip = new \ZipArchive;
        if ($zip->open($source) === TRUE) {
            $zip->extractTo($this->path);
            $zip->close();
        }
    }

    private function createDir(){
        if (!$this->doesExist()){
            mkdir($this->path, 0777, true);
        }
    }

    private function setSha(string $sha){
        $path = $this->path.'/sha.txt';
        file_put_contents($path, $sha);
    }

    public function getPath(string $path){
        $objectspath = $this->path
                    . '/'
                    . $this->CacheItem->getName()
                    . '-'
                    . $this->getCachedSha();
        $chars = str_split($path);
        if ($chars[0] === '.') {
            $path = $objectspath.substr($path, 1);
        }
        return $path;
    }

}