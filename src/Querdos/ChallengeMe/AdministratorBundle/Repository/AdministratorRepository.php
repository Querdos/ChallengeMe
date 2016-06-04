<?php
/**
 * Created by Hamza ESSAYEGH
 * Date : 6/4/16
 * Time : 7:22 PM
 */

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
        $this
            ->getEntityManager()
            ->persist($admin)
        ;
        $this
            ->getEntityManager()
            ->flush()
        ;
    }


    /**
     * Update admin
     *
     * @param Administrator $admin
     */
    public function update(Administrator $admin) {
        $this
            ->getEntityManager()
            ->persist($admin)
        ;
        $this 
            ->getEntityManager()
            ->flush()
        ;
    }

    /**
     * Remove admin from database
     *
     * @param Administrator $admin
     */
    public function delete(Administrator $admin) {
        $this
            ->getEntityManager()
            ->remove($admin)
        ;
        $this
            ->getEntityManager()
            ->flush()
        ;
    }

    /**
     * Check if an admin exists
     *
     * @param   Administrator $admin
     * @return  Administrator|null
     */
    public function adminExists(Administrator $admin) {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('admin.apiKey')
            ->from("AdminBundle:Administrator", "admin")
            ->where("admin.username = :username")
            ->setParameter("username", $admin->getUsername())
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Get the admin username, password and email
     *
     * @param   $username
     * @return  array
     */
    public function getAdminData($username) {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select("admin.id", "admin.username", "admin.password", "admin.email")
            ->from("AdminBundle:Administrator", "admin")
            ->where("admin.username = :username")
            ->setParameter("username", $username)
        ;

        return $query
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Return the public info of an admin
     *
     * @param   $id
     * @return  mixed
     */
    public function getAdminPublicInfo($id) {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select("admin.username", "admin.email", "info.firstName", "info.lastName", "info.birthday")
            ->from("AdminBundle:Administrator", "admin")
            ->innerJoin("admin.infoUser", "info")
            ->where("admin.id = :id")
            ->setParameter("id", $id)
        ;

        return $query
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Check username existence for an admin
     *
     * @param   $username
     * @return  array
     */
    public function checkUsername($username) {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select("admin.username")
            ->from("AdminBundle:Administrator", "admin")
            ->where("admin.username = :username")
            ->setParameter("username", $username)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Check email existence for an admin
     *
     * @param   $email
     * @return  array
     */
    public function checkEmail($email) {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select("admin.email")
            ->from("AdminBundle:Administrator", "admin")
            ->where("admin.email = :email")
            ->setParameter("email", $email)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Check emaiBack existance for an admin
     * (as emailBack, and check too if it exists
     * as a main email)
     *
     * @param $email
     * @return string|null
     */
    public function checkEmailBack($email) {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select("admin.emailBack")
            ->from("AdminBundle:Administrator", "admin")
            ->where("admin.emailBack = :email")
            ->setParameter("email", $email)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }
}
