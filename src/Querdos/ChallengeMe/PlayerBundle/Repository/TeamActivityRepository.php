<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/27/17
 * Time: 3:57 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\PlayerBundle\Entity\TeamActivity;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class TeamActivityRepository extends EntityRepository
{
    /**
     * Read recent activities for the current team (max 5)
     *
     * @param Team $team
     *
     * @return TeamActivity[]
     */
    public function readForTeam(Team $team)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('team_activity')
            ->from('PlayerBundle:TeamActivity', 'team_activity')

            ->join('team_activity.team', 'team')

            ->where('team = :team')
            ->setParameter('team', $team)
        ;

        return $query
            ->getQuery()
            ->getResult()
        ;
    }
}