<?php

class Course
{
    public function __construct(
        private string $code,
        private string $title,
        private int    $credits
    ) {}

    public function getInfo(): string
    {
        return "{$this->code} – {$this->title} ({$this->credits} kredit)";
    }
}
