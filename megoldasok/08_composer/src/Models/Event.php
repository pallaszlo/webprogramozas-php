<?php

namespace App\Models;

use Carbon\Carbon;

class Event
{
    public function __construct(
        private string $title,
        private string $location,
        private Carbon $date,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function isUpcoming(): bool
    {
        return $this->date->isFuture();
    }
}
