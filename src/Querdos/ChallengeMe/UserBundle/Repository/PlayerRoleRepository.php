<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/18/17
 * Time: 12:16 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\UserBundle\Entity\PlayerRole;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class PlayerRoleRepository extends EntityRepository
{
    /**
     * Return all custom roles for the given team
     *
     * @param Team $team
     *
     * @return PlayerRole[]
     */
    public function readByTeam(Team $team)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('player_role')
            ->from('UserBundle:PlayerRole', 'player_role')

            ->join('player_role.team', 'team')
            ->where('team = :team')

            ->setParameter('team', $team)
        ;

        return $query
            ->getQuery()
            ->getArrayResult()
        ;
    }
}