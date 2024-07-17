<?php 

namespace Kenjiefx\Scribe\Commands;
use Kenjiefx\Scribe\Config\Configuration;
use Kenjiefx\Scribe\Config\Dependencies;
use Kenjiefx\Scribe\Config\EnvHelper;
use Kenjiefx\Scribe\Pullers\GitHubPuller;
use Kenjiefx\Scribe\Pushers\PushManager;
use Kenjiefx\Scribe\Services\GitHub\GitHubAPIClient;
use Kenjiefx\Scribe\Services\GitHub\GitHubService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'pull')]
class Pull extends Command {

    protected static $defaultDescription = 'Pulls dependencies to your application';

    protected function execute(
        InputInterface $input, 
        OutputInterface $output
        ): int
    {
        Configuration::load();
        foreach (Dependencies::get() as $dependency) {
            $source = $dependency->getSource();
            if ($source === 'github') {
                $puller = new GitHubPuller($dependency);
                $puller->pull();
            }
            (new PushManager($dependency))->push();
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to pull dependencies that are declared in your scribe.json file.');
    }

}