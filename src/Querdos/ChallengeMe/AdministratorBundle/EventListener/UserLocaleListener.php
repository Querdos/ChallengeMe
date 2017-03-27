<?php
/**
 * Created by Hamza ESSAYEGH
 * Date: 8/14/16
 * Time: 6:09 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\EventListener;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class UserLocaleListener
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Set the session
     *
     * @param Session $session
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if (null !== $user->getInfoUser()->getLocale()) {
            $this->session->set('_locale', $user->getInfoUser()->getLocale());
        }
    }
}