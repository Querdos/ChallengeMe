<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/27/17
 * Time: 4:00 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Manager;

use Querdos\ChallengeMe\PlayerBundle\Entity\TeamActivity;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class TeamActivityManager extends BaseManager
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
        return $this->repository->readForTeam($team);
    }
}