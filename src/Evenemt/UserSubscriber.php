<?php

namespace App\Evenemt;

use Symfony\Component\EventDispatcher\Event;
//use symfony\Contracts\EventDispatcher\Event;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserSubscriber implements EventSubscriberInterface 
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session=$session;
    }
    public function displayRegisterMessage() 
    {
        $this->session->getFlashBag()->add('success', 'Vous êtes bien connectés');
    }
    static function getSubscribedEvents()
    {
        return 
        [
        RegisterEvent::NAME => 
            [
            'displayRegisterMessage'
            ]
        ];
}
}