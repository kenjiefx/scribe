<?php

namespace Kenjiefx\Scribe\Core\Packages;

use Kenjiefx\Scribe\Core\Repositories\RepositoryModel;

class PackageModel
{

    public readonly string $name;

    public function __construct(
        public readonly RepositoryModel $repository
    ) {
        $this->name = "$repository->owner/$repository->name";
    }


}