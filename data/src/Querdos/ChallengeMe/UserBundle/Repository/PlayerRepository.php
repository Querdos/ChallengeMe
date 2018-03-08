<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/8/17
 * Time: 11:28 AM
 */

namespace Querdos\ChallengeMe\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Symfony\Component\VarDumper\VarDumper;

class PlayerRepository extends EntityRepository
{
    /**
     * Get the player username, password and email
     *
     * @param string $username
     *
     * @return null|Player
     */
    public function getPlayerData($username)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select("player")
            ->addSelect("infoUser")
            ->addSelect("personalInformation")

            ->from("UserBundle:Player", "player")
            ->join("player.infoUser", "infoUser")
            ->join("infoUser.personalInformation", "personalInformation")

            ->where("player.username = :username")

            ->setParameter("username", $username)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Return the count of existing players in database
     *
     * @return int
     */
    public function getPlayerCount()
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('COUNT(player)')
            ->from('UserBundle:Player', 'player')
        ;

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * Return the list of resources for all teams
     * (used when restoring database)
     *
     * @return array
     */
    public function resourcesForAll()
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('player.avatarName as resource')
            ->from('UserBundle:Player', 'player')

            ->where('player.avatarName IS NOT NULL')
        ;

        $results = $query
            ->getQuery()
            ->getResult()
        ;

        $data = [];
        foreach ($results as $result) {
            $data[] = $result['resource'];
        }

        return $data;
    }
}