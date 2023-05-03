<?php

namespace MintDev\LoadTester;

use Dotenv;

require __DIR__.'/../vendor/autoload.php';

class ReadEnv
{
    public function __construct(
        public string $home
    ) {
        $dotenv = Dotenv\Dotenv::createMutable($this->home);
        $dotenv->load();
    }
}