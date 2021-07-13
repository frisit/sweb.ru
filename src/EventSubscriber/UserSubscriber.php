<?php

use App\Event\RegisteredUserEvent;
use App\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Error\Error;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * UserSubscriber constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            RegisteredUserEvent::NAME => 'onUserRegister'
        ];
    }

    /**
     * @param RegisteredUserEvent $registeredUserEvent
     * $throws Twig\Error\Error
     * $throws Twig\Error\RuntimeError
     * $throws Twig\Error\SyntaxError
     * */
    public function onUserRegister(RegisteredUserEvent $registeredUserEvent)
    {
        $this->mailer->sendConfirmationMessage($registeredUserEvent->getRegisteredUser());
    }
}
