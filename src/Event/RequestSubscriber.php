<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class RequestSubscriber implements EventSubscriberInterface
{
    public function onRequestEvent(RequestEvent $requestEvent)
    {
        // TODO: перенести подписчиков в соответствующий каталог
        // TODO: вместо использования var_dump, взять компонент messenger и использовать RabbitMQ
        var_dump(
            $requestEvent->getSubject(),
            $requestEvent->getArguments()
        );
    }

    public static function getSubscribedEvents(): array
    {

        return [
            RequestEvent::class => 'onRequestEvent'
        ];
    }
}