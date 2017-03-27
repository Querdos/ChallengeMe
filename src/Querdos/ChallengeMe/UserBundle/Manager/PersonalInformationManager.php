<?php
/**
 * Created by Hamza ESSAYEGH
 * Date: 8/15/16
 * Time: 3:59 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Querdos\ChallengeMe\UserBundle\Entity\PersonalInformation;
use Symfony\Component\Security\Core\User\UserInterface;

class PersonalInformationManager extends BaseManager
{
    /**
     * Read Personal Information for a given user
     *
     * @param UserInterface $user
     *
     * @return PersonalInformation
     */
    public function readForUser(UserInterface $user)
    {
        return $this->repository->readForUser($user);
    }
}