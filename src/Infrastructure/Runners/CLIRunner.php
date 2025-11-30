<?php

namespace Kenjiefx\Scribe\Infrastructure\Runners;

use Kenjiefx\Scribe\Infrastructure\Cache\LocalCacheService;
use Kenjiefx\Scribe\Application\ScribeJSON\ScribeJSONLister;
use Kenjiefx\Scribe\Infrastructure\Files\FileManager;
use Kenjiefx\Scribe\Infrastructure\Platforms\GitHub\GitHubClient;
use Kenjiefx\Scribe\Interfaces\RunnerInterface;
use Kenjiefx\Scribe\Container;
use Kenjiefx\Scribe\Infrastructure\Commands\PullCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

/**
 * CLIRunner class implements the RunnerInterface for handling command line interface (CLI) execution.
 * This runner is used when the application is running in a command line context.
 */
class CLIRunner implements RunnerInterface
{
    private Application $applicationRunner;

    public function __construct()
    {
    }

    public function bootstrap(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(ROOT . "/.env");
        Container::create();
        Container::bind()->SourceListingInterface((Container::get(ScribeJSONLister::class)));
        Container::bind()->GitHubClientInterface(Container::get(GitHubClient::class));
        Container::bind()->CacheManagerInterface(Container::get(LocalCacheService::class));
        Container::bind()->FileManagerInterface(Container::get(FileManager::class));
        $this->applicationRunner = new Application();
        $this->applicationRunner->add(Container::get(PullCommand::class));
    }

    public function execute(): void
    {
        // Handle command line arguments and execute the appropriate commands
        // This could involve parsing arguments, executing commands, etc.
        $this->applicationRunner->run();
    }
}