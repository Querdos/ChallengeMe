<?php
/**
 * Created by Hamza ESSAYEGH
 * Date : 6/4/16
 * Time : 7:22 PM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\AdministratorBundle\Entity\Moderator;

/**
 * ModeratorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ModeratorRepository extends EntityRepository
{
    /**
     * Persists new moderator to the database
     *
     * @param Moderator $moderator
     */
    public function create(Moderator $moderator) {
        $this
            ->getEntityManager()
            ->persist($moderator);

        $this
            ->getEntityManager()
            ->flush();
    }

    /**
     * Update existing moderator
     * 
     * @param Moderator $moderator
     */
    public function update(Moderator $moderator) {
        $this
            ->getEntityManager()
            ->persist($moderator)
        ;
        
        $this
            ->getEntityManager()
            ->flush()
        ;
    }

    /**
     * Remove moderator from the database
     *
     * @param Moderator $moderator
     */
    public function delete(Moderator $moderator) {
        $this
            ->getEntityManager()
            ->remove($moderator)
        ;
        
        $this
            ->getEntityManager()
            ->flush()
        ;
    }

    /**
     * Retrieve the moderator data with a given username
     *
     * @param   string  $username
     * @return  array
     */
    public function getModeratorData($username)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('moderator.id as id')
            ->addSelect('moderator.username')
            ->addSelect('moderator.password')
            ->addSelect('moderator.email')
            ->addSelect('info.firstName as firstname')
            ->addSelect('info.lastName as lastname')
            ->addSelect('info.birthday as birthday')

            ->from('AdminBundle:Moderator', 'moderator')
            ->join('moderator.infoUser', 'info')
            ->where('moderator.username = :username')

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
    public function getModeratorPublicInfo($id)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('m.username')
            ->addSelect('m.email')
            ->addSelect('info.firstName')
            ->addSelect('info.lastName')
            ->addSelect('info.birthday')

            ->from("AdminBundle:Moderator", 'm')
            ->innerJoin('m.infoUser', 'info')

            ->where('m.id = :id')

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

            ->select('m.username')

            ->from('AdminBundle:Moderator', 'm')

            ->where('m.username = :username')

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

            ->select('m.email')

            ->from('AdminBundle:Moderator', 'm')

            ->where('m.email = :email')

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

            ->select('m.emailBack')

            ->from('AdminBundle:Moderator', 'm')

            ->where('m.emailBack = :email')

            ->setParameter('email', $email)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult();
    }


}
