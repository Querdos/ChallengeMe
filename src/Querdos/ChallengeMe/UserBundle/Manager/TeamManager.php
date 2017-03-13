<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/9/17
 * Time: 1:53 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;


use Querdos\ChallengeMe\UserBundle\Entity\Team;

class TeamManager extends BaseManager
{
    /**
     * Create a team in database
     *
     * @param Team $team
     */
    public function create($team)
    {
        // adding the leader to the team
        $team
            ->getLeader()
            ->setTeam($team)
        ;

        // persisting the team
        parent::create($team);

        // persisting the leader
        $this->entityManager->persist($team->getLeader());
        $this->entityManager->flush($team->getLeader());
    }
}