<?php

namespace App\Event;

interface EventSubscriberInterface
{
    /**
     * @return array
     */
    public function getSubscriberEvents(): array;
}