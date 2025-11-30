<?php

namespace Kenjiefx\Scribe\Interfaces;

/**
 * This interface defines the methods that any runner 
 * must implement to ensure consistent behavior
 * across different runtime contexts (e.g., HTTP, CLI).
 */
interface RunnerInterface
{
    /**
     * Initializes the runner.
     */
    public function bootstrap(): void;

    /**
     * Executes the main logic of the runner.
     */
    public function execute(): void;
}