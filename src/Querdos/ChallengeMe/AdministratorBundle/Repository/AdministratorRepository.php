<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;

/**
 * AdministratorRepository
 */
class AdministratorRepository extends EntityRepository
{
    public function create(Administrator $admin) {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();
    }
}
