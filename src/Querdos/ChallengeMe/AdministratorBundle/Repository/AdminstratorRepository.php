<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Adminstrator;

/**
 * AdminstratorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdminstratorRepository extends EntityRepository
{
    public function create(Adminstrator $admin) {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();
    }
}
