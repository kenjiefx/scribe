<?php 

namespace Kenjiefx\Scribe;

class Release {

    /**
     * The version of the specific release
     */
    private string $tagName;

    /**
     * A link where you can download the source code
     */
    private string $srcUrl;

    public function __construct() {
    }

    /**
     * Sets the owner of the tag name of the release
     */
    public function setTagName(string $tagName): Release {
        $this->tagName = $tagName;
        return $this;
    }

    /**
     * Gets the owner of the tag name of the release
     */
    public function getTagName(): string {
        return $this->tagName;
    }

    /**
     * Sets the the url where source code can be donwloaded
     */
    public function setSrcUrl(string $srcUrl): Release {
        $this->srcUrl = $srcUrl;
        return $this;
    }  

    /**
     * Sets the the url where source code can be donwloaded
     */
    public function getSrcUrl(): string {
        return $this->srcUrl;
    }
    
}