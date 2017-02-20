<?php
/**
 * Created by Hamza ESSAYEGH
 * Date : 6/4/16
 * Time : 7:22 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Administrator;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Role;

/**
 * AdministratorRepository
 */
class AdministratorRepository extends EntityRepository
{
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

            ->select("admin")
            ->addSelect("infoUser")
            ->addSelect("personalInformation")

            ->from("AdminBundle:Administrator", "admin")
            ->join('admin.infoUser', 'infoUser')
            ->join('infoUser.personalInformation', 'personalInformation')

            ->where("admin.username = :username")

            ->setParameter("username", $username)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Return the public info of an admin
     *
     * @param   $id
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

    /**
     * Return a list of all administrators, depending on their role.
     *
     * Allowed role:
     *      ROLE_ADMIN
     *      ROLE_MODERATOR
     *      ROLE_REDACTOR
     *
     * @param   string $role
     * @return  array
     * @throws  \Exception
     */
    public function all($role)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        switch ($role){
            case Role::ROLE_ADMIN:
                $query
                    ->select("admin")
                    ->from("AdminBundle:Administrator", "admin")

                    ->join("admin.role", "role")
                    ->where("role.value = :rolename")

                    ->setParameter("rolename", $role)
                ;
            break;

            case Role::ROLE_MODERATOR:
                $query
                    ->select("admin")
                    ->from("AdminBundle:Administrator", "admin")

                    ->join("admin.role", "role")
                    ->where("role.value = :rolename")

                    ->setParameter("rolename", $role)
                ;
            break;

            case Role::ROLE_REDACTOR:
                $query
                    ->select("admin")
                    ->from("AdminBundle:Administrator", "admin")

                    ->join("admin.role", "role")
                    ->where("role.value = :rolename")

                    ->setParameter("rolename", $role)
                ;
            break;

            default:
                throw new \Exception("Role not recognized.");
            break;
        }

        return $query
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
