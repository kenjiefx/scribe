<?php

namespace Kenjiefx\Scribe\Core\Releases;

class ReleaseModel
{
    public function __construct(
        /**
         * @var string The tag name of the release
         * @example v1.0.0
         */
        public readonly string $tagName,

        /**
         * @var string A link where you can download the release
         */
        public readonly string $srcUrl
    ) {
    }
}