<?php 

namespace Kenjiefx\Scribe\Config;
use Kenjiefx\Scribe\Config\Dependencies;

class Configuration {

    public const CONFIG_FILE_NAME = '/scribe.json';
    private static array $configuration = [];
    private static bool $status = false;
    private const HAS_LOADED = true;

    public static function load(){

        if (static::$status === Configuration::HAS_LOADED) return;

        $scribeJson = ROOT.Configuration::CONFIG_FILE_NAME;

        if (!file_exists($scribeJson)) {
            throw new \Exception('Unable to locate scribe.json file in your ' . 
                'project directory');
        }

        $configuration = json_decode(file_get_contents($scribeJson),TRUE);

        if (json_last_error()!==0) {
            throw new \Exception('Unable to parse scribe.json file, probably ' . 
                'due to invalid json structure');
        }

        Dependencies::load($configuration);

    }



}