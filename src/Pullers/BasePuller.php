<?php 

namespace Kenjiefx\Scribe\Pullers;

class BasePuller {

    protected function getTempFile(){
        return __dir__.'/tmp.zip';
    }

}