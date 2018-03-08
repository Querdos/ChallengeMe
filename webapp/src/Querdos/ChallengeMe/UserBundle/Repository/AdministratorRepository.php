<?php
/**
 * Created by Hamza ESSAYEGH
 * Date : 6/4/16
 * Time : 7:22 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\Role;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * AdministratorRepository
 */
class AdministratorRepository extends EntityRepository
{
    /**
     * Get the admin username, password and email
     *
     * @param   string $username
     * @return  null | Administrator
     */
    public function getAdminData($username) {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select("admin")
            ->addSelect("infoUser")
            ->addSelect("personalInformation")

            ->from("UserBundle:Administrator", "admin")
            ->join('admin.infoUser', 'infoUser')
            ->join('infoUser.personalInformation', 'personalInformation')

            ->where("admin.username = :username")

            ->setParameter("username", $username)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Return the public info of an admin
     *
     * @param   int     $id
     * @return  array
     */
    public function getAdminPublicInfo($id) {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select("admin.username as username")
            ->addSelect("admin.email as email")
            ->addSelect("admin.emailBack as emailBack")
            ->addSelect("info.firstName as firstname")
            ->addSelect("info.lastName as lastname")
            ->addSelect("info.birthday as birthday")

            ->from("UserBundle:Administrator", "admin")
            ->innerJoin("admin.infoUser", "info")
            
            ->where("admin.id = :id")
            
            ->setParameter("id", $id)
        ;

        return $query
            ->getQuery()
            ->getSingleResult()
        ;
    }

    /**
     * Check username existence for an admin
     *
     * @param   string $username
     * @return  Administrator | null
     */
    public function checkUsername($username) {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select("admin.username")
            
            ->from("UserBundle:Administrator", "admin")
            
            ->where("admin.username = :username")
            
            ->setParameter("username", $username)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Check email existence for an admin
     *
     * @param   string $email
     * @return  string | null
     */
    public function checkEmail($email) {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select("admin.email")
            
            ->from("UserBundle:Administrator", "admin")
            
            ->where("admin.email = :email")
            
            ->setParameter("email", $email)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Check emailBack existance for an admin
     * (as emailBack, and check too if it exists
     * as a main email)
     *
     * @param  string $email
     * @return string | null
     */
    public function checkEmailBack($email) {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select("admin.emailBack")
            ->from("UserBundle:Administrator", "admin")
            ->where("admin.emailBack = :email")
            ->setParameter("email", $email)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Return all administrators, depending on the role.
     *
     * Allowed roles:
     *      ROLE_ADMIN
     *      ROLE_MODERATOR
     *      ROLE_REDACTOR
     *
     * @param Role $role
     * @return array
     */
    public function all($role)
    {
        // checking role
        if (false === Role::check($role)) {
            throw new Exception("Role not found.");
        }

        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select("admin")
            ->addSelect("info_user")

            ->from("UserBundle:Administrator", "admin")
            ->join("admin.role", "role")
            ->join("admin.infoUser", "info_user")
            ->where("role.value = :rolevalue")

            ->setParameter("rolevalue", $role)
        ;

        return $query
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /**
     * Return the count of existant administrators in database
     *
     * @return int
     */
    public function getAdminCount()
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('COUNT(admin)')
            ->from('UserBundle:Administrator', 'admin')

            ->join('admin.role', 'role')
            ->where('role.value = :role_admin')

            ->setParameter('role_admin', Role::ROLE_ADMIN);
        ;

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * Return the count of existant moderators in database
     *
     * @return int
     */
    public function getModoCount()
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('COUNT(admin)')
            ->from('UserBundle:Administrator', 'admin')

            ->join('admin.role', 'role')
            ->where('role.value = :role_admin')

            ->setParameter('role_admin', Role::ROLE_MODERATOR);
        ;

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * Return the count of existing redactors in database
     *
     * @return int
     */
    public function getRedacCount()
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('COUNT(admin)')
            ->from('UserBundle:Administrator', 'admin')

            ->join('admin.role', 'role')
            ->where('role.value = :role_admin')

            ->setParameter('role_admin', Role::ROLE_REDACTOR);
        ;

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
