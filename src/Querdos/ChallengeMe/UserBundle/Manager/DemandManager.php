<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/15/17
 * Time: 3:41 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Querdos\ChallengeMe\UserBundle\Entity\Demand;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class DemandManager extends BaseManager
{
    /**
     * Return all demands with a given team
     *
     * @param Team $team
     *
     * @return Demand[]
     */
    public function readByTeam(Team $team)
    {
        return $this->repository->readByTeam($team);
    }

    /**
     * Change the status to accepted for the given demand
     *
     * @param Demand $demand
     */
    public function acceptDemand(Demand $demand)
    {
        $demand->setStatus(Demand::STATUS_ACCEPTED);
        $this->update($demand);
    }

    /**
     * Change the status to declined for the given demand
     *
     * @param Demand $demand
     */
    public function declineDemand(Demand $demand)
    {
        $demand->setStatus(Demand::STATUS_DECLINED);
        $this->update($demand);
    }
}