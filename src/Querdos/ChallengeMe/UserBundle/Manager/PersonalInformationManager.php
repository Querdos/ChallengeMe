<?php
/**
 * Created by Hamza ESSAYEGH
 * Date: 8/15/16
 * Time: 3:59 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Querdos\ChallengeMe\UserBundle\Repository\PersonalInformationRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class PersonalInformationManager
{
    /**
     * @var PersonalInformationRepository
     */
    private $repository;

    /**
     * Set the repository
     *
     * @param PersonalInformationRepository $repository
     *
     * @return $this
     */
    public function setRepository(PersonalInformationRepository $repository)
    {
        $this->repository = $repository;
        return $this;
    }

    public function readForUser(UserInterface $user)
    {
        return $this->repository->readForUser($user);
    }
}