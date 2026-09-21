<?php

// Kiegészítés (nem szerepel a könyvben): a 3.55. kódpéldában használt Course osztály

class Course
{
    public function __construct(
        private string $title,
        private int $credits
    ) {}

    public function getInfo(): string
    {
        return "Kurzus: {$this->title}, {$this->credits} kredit";
    }
}
