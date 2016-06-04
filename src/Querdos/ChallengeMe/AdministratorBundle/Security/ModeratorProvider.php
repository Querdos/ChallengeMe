<?php
/**
 * Created by PhpStorm.
 * User: Hamza ESSAYEGH
 * Date: 5/31/16
 * Time: 11:57 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Security;


use Querdos\ChallengeMe\AdministratorBundle\Manager\ModeratorManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ModeratorProvider implements UserProviderInterface
{
    /**
     * @var ModeratorManager
     */
    private $moderatorManager;

    /**
     * ModeratorProvider constructor.
     * 
     * @param ModeratorManager $moderatorManager
     */
    public function __construct(ModeratorManager $moderatorManager)
    {
        $this->moderatorManager = $moderatorManager;
    }

    public function loadUserByUsername($username)
    {
        /** @var array $userData */
//        $userData = $this->moderatorManager->
    }

    public function refreshUser(UserInterface $user)
    {
        // TODO: Implement refreshUser() method.
    }

    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }
}