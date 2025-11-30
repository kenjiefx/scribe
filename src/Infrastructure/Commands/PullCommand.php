<?php

namespace Kenjiefx\Scribe\Infrastructure\Commands;

use Kenjiefx\Scribe\Application\UseCases\PullUseCase;
use Kenjiefx\Scribe\Interfaces\SourceListingInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Kenjiefx\Scribe\Container;

#[AsCommand(name: 'pull')]
class PullCommand extends Command
{

    protected static $defaultDescription = 'Pulls objects to your application';

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $pullUseCase = Container::get(PullUseCase::class);
        /**
         * @var SourceListingInterface
         */
        $configuration = Container::get(SourceListingInterface::class);
        $pullUseCase->execute($configuration->getSources());
        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to pull from sources declared in your Scribe configuration.');
    }

}