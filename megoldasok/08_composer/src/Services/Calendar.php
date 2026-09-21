<?php

namespace App\Services;

use App\Models\Event;

class Calendar
{
    /** @var Event[] */
    private array $events = [];

    public function addEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    /**
     * Visszaadja a jövőbeli eseményeket dátum szerint rendezve.
     *
     * @return Event[]
     */
    public function getUpcomingEvents(): array
    {
        $upcoming = array_filter(
            $this->events,
            fn(Event $e) => $e->isUpcoming()
        );

        usort($upcoming, fn(Event $a, Event $b) =>
            $a->getDate()->timestamp <=> $b->getDate()->timestamp
        );

        return array_values($upcoming);
    }
}
