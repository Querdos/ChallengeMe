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

    public function adminExists(Administrator $admin) {
        $query = $this->_em->createQueryBuilder()
            ->select('admin.apiKey')
            ->from("AdminBundle:Administrator", "admin")
            ->where("admin.username = :username")
            ->setParameter("username", $admin->getUsername());

        return $query->getQuery()->getResult();
    }

    /**
     * Get the admin username, password and email
     *
     * @param $username
     *
     * @return array
     */
    public function getAdminData($username) {
        $query = $this->_em->createQueryBuilder()
            ->select("admin.username", "admin.password", "admin.email")
            ->from("AdminBundle:Administrator", "admin")
            ->where("admin.username = :username")
            ->setParameter("username", $username);

        return $query->getQuery()->getSingleResult();
    }
}
