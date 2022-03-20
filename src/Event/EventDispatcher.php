<?php

namespace App\Event;

class EventDispatcher
{
    private array $subscribers = [];

    public function addSubscriber(RequestSubscriber $subscriber)
    {
        $this->subscribers[] = $subscriber;
    }

    public function dispatch(Event $event)
    {
        $eventClass = \get_class($event);

        // TODO: возможно, стоит array_keys вынести в переменную т.к. это ускорит выполнение команд
        /** @var EventSubscriberInterface */
        foreach ($this->subscribers as $subscriber) {
            if(in_array($eventClass, \array_keys($subscriber->getSubscribedEvents()))) {
                $method = $subscriber->getSubscribedEvents()[$eventClass];
            }
        }

        return;
    }



}