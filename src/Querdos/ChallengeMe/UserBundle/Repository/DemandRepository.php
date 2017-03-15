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
use Querdos\ChallengeMe\UserBundle\Entity\Team;

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
}