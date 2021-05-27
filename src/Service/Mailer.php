<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Twig\Environment;
use Swift_Mailer;

class Mailer
{
    public const FROM_ADDRESS = 'test@test.ru';

    private $mailer;

    private $twig;


    public function __construct(Swift_Mailer $mailer, Environment  $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendConfirmationMessage(User $user)
    {
        $messageBody = $this->twig->render('security/confirmation.html.twig', [
            'user' => $user
        ]);

        $message = new \Swift_Message();
        $message
            ->setSubject('успешно прошли регистрацию')
            ->setFrom(self::FROM_ADDRESS)
            ->setTo($user->getEmail())
            ->setBody($messageBody, 'text/html');

        $this->mailer->send($message);
    }

}