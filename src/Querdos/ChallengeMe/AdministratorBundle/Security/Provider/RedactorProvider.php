<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/7/16
 * Time: 10:41 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Security\Provider;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Redactor;
use Querdos\ChallengeMe\AdministratorBundle\Manager\RedactorManager;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class RedactorProvider implements UserProviderInterface
{

    /** @var  RedactorManager $redactorManager */
    private $redactorManager;

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        /** @var array $userData */
        $userData = $this->redactorManager->getRedactorData($username);

        if ($userData) {
            return new Redactor(
                $userData['id'],
                $userData['username'],
                $userData['email'],
                $userData['password']
            );
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Redactor) {
            throw new UnsupportedUserException(
                sprintf("Instance of %s are not supported", get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === 'AdminBundle\\Entity\\Redactor';
    }

    /**
     * @param RedactorManager $redactorManager
     */
    public function setRedactorManager($redactorManager)
    {
        $this->redactorManager = $redactorManager;
    }

    public function getClassName()
    {
        return $this->getClassName();
    }
}