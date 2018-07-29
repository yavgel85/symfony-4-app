<?php

namespace App\Event;

use App\Entity\UserPreferences;
use App\Mailer\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /** @var Mailer */
    private $mailer;

    /** @var EntityManagerInterface */
    private $em;

    /** @var string */
    private $defaultLocale;

    public function __construct(Mailer $mailer, EntityManagerInterface $em, string $defaultLocale)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->defaultLocale = $defaultLocale;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisterEvent::NAME => 'onUserRegister',
        ];
    }

    public function onUserRegister(UserRegisterEvent $event): void
    {
        $preferences = new UserPreferences();
        $preferences->setLocale($this->defaultLocale);

        $user = $event->getRegisteredUser();
        $user->setPreferences($preferences);

        $this->em->flush();

        $this->mailer->sendConfirmationEmail($event->getRegisteredUser());
    }
}