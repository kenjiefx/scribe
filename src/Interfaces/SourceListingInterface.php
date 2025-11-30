<?php

namespace Kenjiefx\Scribe\Interfaces;

use Kenjiefx\Scribe\Core\Sources\SourceIterator;

/**
 * An interface for classes that handles listing of sources.
 * This allows different implementations for source listing,
 * such as from a database, configuration file, or external service.
 */
interface SourceListingInterface
{
    /**
     * Returns a SourceIterator.
     * @return SourceIterator
     */
    public function getSources(): SourceIterator;
}