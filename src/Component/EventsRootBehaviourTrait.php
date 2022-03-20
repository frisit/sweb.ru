<?php

namespace App\Component;

trait EventsRootBehaviourTrait
{
    /**
     * @var array
     */
    private array $events = [];

    /**
     * @param $event
     */
    protected function fireEvent($event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return array
     */
    public function releaseEvents(): array
    {
        [$events, $this->events] = [$this->events, []];
        return $events;
    }

}