<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;

/**
 * AdministratorRepository
 */
class AdministratorRepository extends EntityRepository
{
    /**
     * Persist new admin to the database
     *
     * @param Administrator $admin
     */
    public function create(Administrator $admin) {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();
    }

    /**
     * Check if an admin exists
     *
     * @param Administrator $admin
     * @return array
     */
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
            ->select("admin.id", "admin.username", "admin.password", "admin.email")
            ->from("AdminBundle:Administrator", "admin")
            ->where("admin.username = :username")
            ->setParameter("username", $username);

        return $query->getQuery()->getSingleResult();
    }

    public function getAdminPublicInfo($id) {
        $query = $this->_em->createQueryBuilder()
            ->select("admin.username", "admin.email", "info.firstName", "info.lastName", "info.birthday")
            ->from("AdminBundle:Administrator", "admin")
            ->innerJoin("admin.infoUser", "info")
            ->where("admin.id = :id")
            ->setParameter("id", $id);

        return $query->getQuery()->getSingleResult();
    }
}
