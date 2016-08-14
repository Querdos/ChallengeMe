<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Redactor;

/**
 * RedactorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RedactorRepository extends EntityRepository
{
    /**
     * Retrieve the moderator data with a given username
     *
     * @param   string  $username
     * @return  array
     */
    public function getRedactorData($username)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('redactor.id as id')
            ->addSelect('redactor.username')
            ->addSelect('redactor.password')
            ->addSelect('redactor.email')
            ->addSelect('info.firstName as firstname')
            ->addSelect('info.lastName as lastname')
            ->addSelect('info.birthday as birthday')
            ->addSelect('info.locale as locale')

            ->from('AdminBundle:Redactor', 'redactor')
            ->join('redactor.infoUser', 'info')
            ->where('redactor.username = :username')

            ->setParameter('username', $username);
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param   int     $id
     * @return  array
     */
    public function getRedactorPublicInfo($id)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('r.username')
            ->select('r.email')
            ->select('info.firstName')
            ->select('info.lastName')
            ->select('info.birthday')

            ->from("AdminBundle:Redactor", 'r')
            ->innerJoin('r.infoUser', 'info')

            ->where('r.id = :id')

            ->setParameter('id', $id);
        ;

        return $query
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Check if the username exists
     *
     * @param   string  $username
     * @return  string|null
     */
    public function checkUsername($username)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('r.username')

            ->from('AdminBundle:Redactor', 'r')

            ->where('r.username = :username')

            ->setParameter('username', $username)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Check email existence for an admin
     *
     * @param   string      $email
     * @return  string|null
     */
    public function checkEmail($email)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('r.email')

            ->from('AdminBundle:Redactor', 'r')

            ->where('r.email = :email')

            ->setParameter('email', $email);
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Check emaiBack existance for a moderator
     * (as emailBack, and also check if it exists
     * as a main email)
     *
     * @param   string      $email
     * @return  string|null
     */
    public function checkEmailBack($email)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('r.emailBack')

            ->from('AdminBundle:Redactor', 'r')

            ->where('r.emailBack = :email')

            ->setParameter('email', $email)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }
}
