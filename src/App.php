<?php

namespace Kenjiefx\Scribe;

use Kenjiefx\Scribe\Infrastructure\Runners\CLIRunner;
use Kenjiefx\Scribe\Interfaces\RunnerInterface;

class App
{
    private RunnerInterface $runner;

    public function __construct(
        RunnerInterface|null $runner = null
    ) {
        // If a specific runner is provided, use it
        if ($runner !== null) {
            $this->runner = $runner;
            return;
        }
        // If no specific runner is provided, assert 
        // that we are running in CLI context only
        if (php_sapi_name() !== 'cli') {
            throw new \Exception('Application must be '
                . 'run from the command line interface (CLI).');
        }
        $this->runner = new CLIRunner();
    }

    public function run()
    {
        $this->runner->bootstrap();
        $this->runner->execute();
    }
}