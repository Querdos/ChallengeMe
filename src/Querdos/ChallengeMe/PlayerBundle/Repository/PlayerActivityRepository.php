<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/27/17
 * Time: 2:11 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\PlayerBundle\Entity\PlayerActivity;
use Querdos\ChallengeMe\UserBundle\Entity\Player;

class PlayerActivityRepository extends EntityRepository 
{
    /**
     * Return recent activities for the given player (5 max)
     *
     * @param Player $player
     *
     * @return PlayerActivity[]
     */
    public function readForPlayer(Player $player)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('activity')
            ->from('PlayerBundle:PlayerActivity', 'activity')

            ->join('activity.player', 'player')

            ->where('player = :player')
            ->setParameter('player', $player)

            ->orderBy('activity.date', 'DESC')

            ->setMaxResults(5)
        ;

        return $query
            ->getQuery()
            ->getResult();
    }
}