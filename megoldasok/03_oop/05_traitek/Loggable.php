<?php

trait Loggable
{
    public function log(string $message): void
    {
        echo "[" . static::class . "] " . date("H:i:s") . " – $message" . PHP_EOL;
    }
}
