<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/15/17
 * Time: 3:31 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\UserBundle\Entity\Demand;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\Team;
use Symfony\Component\VarDumper\VarDumper;

class DemandRepository extends EntityRepository
{
    /**
     * Get all demands for a given team
     *
     * @param Team $team
     *
     * @return Demand[]
     */
    public function readByTeam(Team $team)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('demand')
            ->from('UserBundle:Demand', 'demand')

            ->join('demand.team', 'team')

            ->where('team = :teamGiven')

            ->setParameter('teamGiven', $team)
        ;

        return $query
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return all demands for a given player (only waiting demands)
     *
     * @param Player $player
     *
     * @return Demand[]
     */
    public function allForPlayer(Player $player)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('team.id')
            ->from('UserBundle:Demand', 'demand')

            ->join('demand.player', 'player')
            ->join('demand.team', 'team')

            ->where('player = :playerToFilter')
            ->andWhere('demand.status = :waitingStatus')

            ->setParameter('playerToFilter', $player)
            ->setParameter('waitingStatus', Demand::STATUS_WAITING)
        ;

        $results = $query
            ->getQuery()
            ->getArrayResult();

        $toReturn = [];

        foreach ($results as $result) {
            $toReturn[] = $result['id'];
        }

        return $toReturn;
    }
}