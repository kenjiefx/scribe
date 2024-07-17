<?php 

namespace Kenjiefx\Scribe\Config;
use Dotenv\Dotenv;

final class EnvHelper
{
    public function __construct() {
        $Dotenv = Dotenv::createImmutable(ROOT);
        $Dotenv->load();
    }

    /**
     * Returns environment variables stored in the .env file,
     * depending on the key passed to this method
     */
    public function getEnvar(string $key): string {
        return $_ENV[$key] ?? null;
    }
}
