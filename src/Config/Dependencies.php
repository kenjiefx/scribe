<?php 

namespace Kenjiefx\Scribe\Config;
use Kenjiefx\Scribe\Dependencies\DependenciesIterator;
use Kenjiefx\Scribe\Dependencies\DependencyModel;
use Kenjiefx\Scribe\Repository;

class Dependencies {
    
    private static ?array $dependencies = null;

    public static function load(array $configuration){

        if (!is_null(self::$dependencies) 
            || !array_key_exists('dependencies',$configuration)) return;

        $dependencies = [];

        foreach ($configuration['dependencies'] as $package => $options) {

            # Dissecting the package name declaration
            $owner = static::retrieveOwner($package);
            $name  = static::getName($package); 

            # Dissecting the options
            $source = static::getSource($package);
            $pulls  = static::getPUll($options);

            # Creating the Repository object
            $repository = new Repository();
            $repository->setOwner($owner)->setName($name);

            $dependency = new DependencyModel();
            $dependency->setRepository($repository)
                       ->setPulls($pulls)
                       ->setSource($source);

            array_push($dependencies, $dependency);
        }

        static::$dependencies = $dependencies;

    }

    public static function get(){
        return static::$dependencies;
    }

    private static function retrieveOwner(string $package){
        $tokens = explode('/', $package);
        $names  = explode(':', $tokens[0]);
        if ($names[1] === '') {
            throw new \Exception('Invalid package declaration, must be ' . 
                'in source:owner/package format');
        }
        return $names[1];
    }

    private static function getName(string $package){
        $tokens = explode('/', $package);
        if (!isset($tokens[1]) || $tokens[1] === '') {
            throw new \Exception('Invalid package declaration, must be ' . 
                'in source:owner/package format');
        }
        return $tokens[1];
    }

    private static function getSource(string $package){
        $tokens = explode('/', $package);
        $names  = explode(':', $tokens[0]);
        if ($names[0] === '') {
            throw new \Exception('Dependency declaration should include ' . 
                'source in repository');
        }
        return $names[0];
    }

    private static function getPull(array $options) {
        if (!isset($options['pull'])) {
            throw new \Exception('Dependency declaration should include ' . 
                'map of pull items');
        }
        return $options['pull'];
    }

}