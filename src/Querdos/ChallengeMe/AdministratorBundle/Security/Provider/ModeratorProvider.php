<?php
/**
 * Created by PhpStorm.
 * User: Hamza ESSAYEGH
 * Date: 5/31/16
 * Time: 11:57 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Security\Provider;


use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;
use Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManager;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ModeratorProvider implements UserProviderInterface
{
    /**
     * @var ModeratorManager
     */
    private $moderatorManager;

    public function loadUserByUsername($username)
    {
        /** @var array $userData */
        $userData = $this->moderatorManager->getModeratorData($username);

        if ($userData) {
            return new Moderator(
                $userData['id'],
                $userData['username'],
                $userData['email'],
                $userData['password']
            );
        }

        return null;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Moderator) {
            throw new UnsupportedUserException(
                sprintf("Instance of %s are not supported", get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'AdminBundle\\Entity\\Moderator';
    }

    /**
     * @param ModeratorManager $moderatorManager
     */
    public function setModeratorManager($moderatorManager)
    {
        $this->moderatorManager = $moderatorManager;
    }

    public function getClassName()
    {
        return $this->getClassName();
    }
}