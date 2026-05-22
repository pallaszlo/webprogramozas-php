<?php

namespace App;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;

class Logger
{
    private MonologLogger $logger;

    public function __construct(string $name = 'app')
    {
        $this->logger = new MonologLogger($name);
        $this->logger->pushHandler(
            new StreamHandler(__DIR__ . '/../logs/app.log', Level::Debug)
        );
    }

    public function info(string $message): void
    {
        $this->logger->info($message);
    }

    public function error(string $message): void
    {
        $this->logger->error($message);
    }
}
