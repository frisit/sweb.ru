<?php

namespace App\Component;

use App\Event\EventsRootInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Flusher
{
    private EntityManagerInterface $em;

    private EventDispatcherInterface $dispatcher;

    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }

    public function flush(EventsRootInterface ...$roots): void
    {
        $this->em->flush();

        foreach($roots as $root)
        {
            foreach($root->releaseEvents() as $event) {
                $this->dispatcher->dispatch($event);
            }
        }
    }
}