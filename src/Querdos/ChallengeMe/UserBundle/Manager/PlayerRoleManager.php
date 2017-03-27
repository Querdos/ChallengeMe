<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/18/17
 * Time: 12:20 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Querdos\ChallengeMe\UserBundle\Entity\PlayerRole;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class PlayerRoleManager extends BaseManager
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
        return $this->repository->readByTeam($team);
    }
}