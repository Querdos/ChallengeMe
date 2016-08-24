<?php
/**
 * Created by Hamza ESSAYEGH
 * Date: 8/15/16
 * Time: 1:27 PM
 */
namespace Querdos\ChallengeMe\AdministratorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class PersonalInformationRepository extends EntityRepository
{
    public function readForUser(UserInterface $user)
    {
        $query = $this->getEntityManager()
                      ->createQueryBuilder()
            ->select('')
        ;
    }
}