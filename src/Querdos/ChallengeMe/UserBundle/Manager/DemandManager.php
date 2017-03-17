<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/15/17
 * Time: 3:41 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\UserBundle\Entity\Demand;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class DemandManager extends BaseManager
{
    /**
     * @var PlayerManager $playerManager
     */
    private $playerManager;

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
        // accepting the demand
        $demand->setStatus(Demand::STATUS_ACCEPTED);

        // adding the player to the team
        $demand->getPlayer()->setTeam($demand->getTeam());
        $this->playerManager->update($demand->getPlayer());

        // updating the demand
        $this->update($demand);
    }

    /**
     * Change the status to declined for the given demand
     *
     * @param Demand $demand
     */
    public function declineDemand(Demand $demand)
    {
        // declining the demand and updating
        $demand->setStatus(Demand::STATUS_DECLINED);
        $this->update($demand);
    }

    /**
     * @param PlayerManager $playerManager
     */
    public function setPlayerManager($playerManager)
    {
        $this->playerManager = $playerManager;
    }
}