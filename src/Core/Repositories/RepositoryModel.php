<?php

namespace Kenjiefx\Scribe\Core\Repositories;

class RepositoryModel
{

    public function __construct(
        public readonly string $owner,
        public readonly string $name
    ) {
    }

}