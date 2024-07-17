<?php 

namespace Kenjiefx\Scribe;
use Kenjiefx\Scribe\Commands\Pull;
use Kenjiefx\Scribe\Factory\ContainerFactory;
use Symfony\Component\Console\Application;
use Kenjiefx\Scribe\Container;

class App {
    private Application $ConsoleApplication;
    private Container $AppContainer;

    public function __construct(){
        $this->ConsoleApplication = new Application();
        $this->ConsoleApplication->add(new Pull());
        $this->AppContainer = new Container(ContainerFactory::create());
        $this->AppContainer->register();
    }

    public function run(){
        $this->ConsoleApplication->run();
    }

}