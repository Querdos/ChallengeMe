<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 18/02/17
 * Time: 18:47
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Querdos\ChallengeMe\UserBundle\Entity\Role;
use Querdos\ChallengeMe\UserBundle\Repository\RoleRepository;

class RoleManager
{
    /**
     * @var RoleRepository $roleRepository
     */
    private $repository;

    /**
     * Return admin role
     *
     * @return Role
     */
    public function adminRole()
    {
        return $this
            ->repository
            ->getAdminRole()
        ;
    }

    /**
     * Return moderator role
     *
     * @return Role
     */
    public function moderatorRole()
    {
        return $this
            ->repository
            ->getModeratorRole()
        ;
    }

    /**
     * Return redactor role
     *
     * @return Role
     */
    public function redactorRole()
    {
        return $this
            ->repository
            ->getRedactorRole()
        ;
    }

    /**
     * @param RoleRepository $roleRepository
     */
    public function setRepository($roleRepository)
    {
        $this->repository = $roleRepository;
    }
}