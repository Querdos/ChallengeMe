<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: Querdos
 * Date: 5/22/16
 * Time: 2:24 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Security\Provider;

use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Manager\AdministratorManager;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AdministratorProvider implements UserProviderInterface
{
    /**
     * @var AdministratorManager
     */
    private $adminManager;

    public function loadUserByUsername($username)
    {
        return $this->adminManager->getAdminData($username);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Administrator)
        {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === "AdminBundle\\Entity\\Administrator";
    }

    /**
     * @param AdministratorManager $adminManager
     */
    public function setAdminManager($adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function getClassName()
    {
        return $this->getClassName();
    }
}