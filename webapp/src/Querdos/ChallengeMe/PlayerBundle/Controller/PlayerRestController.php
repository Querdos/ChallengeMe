<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/15/17
 * Time: 4:42 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Querdos\ChallengeMe\UserBundle\Entity\Demand;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\Team;
use Querdos\ChallengeMe\UserBundle\Manager\DemandManager;
use Querdos\ChallengeMe\UserBundle\Manager\PlayerManager;
use Querdos\ChallengeMe\UserBundle\Manager\TeamManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\VarDumper\VarDumper;

/*
 * TODO @querdos: Finish authentication with OAuth before creating web services
 */
class PlayerRestController extends FOSRestController
{
    /**
     * @return array
     */
    public function getTeamsAction()
    {
        $teams = $this->get('challengeme.manager.team')->all();
        return $teams;
    }

    /**
     * @param int $demandId
     *
     * @throws \Exception
     */
    // TODO @querdos: API DOC
    public function acceptDemandAction($demandId)
    {
        /** @var DemandManager $demandManager */
        $demandManager = $this->get('challengeme.manager.demand');
        /** @var Demand $demand */
        $demand = $demandManager->readById($demandId);
        /** @var PlayerManager $playerManager */
        $playerManager = $this->get('challengeme.manager.player');

        // retreiving current user
        $user = $this->get('security.token_storage')->getToken()->getUser();

        // Checking that the demand was edited by the leader
        $team = $demand->getTeam();

        // checking user
        if ($user->getUsername() !== $team->getLeader()->getUsername()) {
            throw new \Exception("You are not allowed to perform this operation");
        }

        // Checking and setting status
        $demand->setStatus(Demand::STATUS_ACCEPTED);

        // Adding the player to the team
        $demand->getPlayer()->setTeam($team);
        $playerManager->update($demand->getPlayer());

        // updating demand
        $demandManager->update($demand);
    }

    /**
     * @param $demandId
     */
    // TODO @querdos: API DOC
    public function declineDemandAction($demandId)
    {
        /** @var DemandManager $demandManager */
        $demandManager = $this->get('challengeme.manager.demand');

        /** @var Demand $demand */
        $demand = $demandManager->readById($demandId);

        // Checking and setting status
        $demand->setStatus(Demand::STATUS_DECLINED);

        // updating demand
        $demandManager->update($demand);
    }

    /**
     * @param int $demandId
     *
     * @throws \Exception
     */
    // TODO @querdos: API DOC
    public function clearDemandAction($demandId)
    {
        /** @var DemandManager $demandManager */
        $demandManager = $this->get('challengeme.manager.demand');
        /** @var Demand $demand */
        $demand = $demandManager->readById($demandId);

        // retreiving current user
        $user = $this->getUser();
        VarDumper::dump($user);

        // Checking that the demand was edited by the leader
        $team = $demand->getTeam();

        // checking user
        if ($user->getUsername() !== $team->getLeader()->getUsername()) {
            throw new \Exception("You are not allowed to perform this operation");
        }

        // removing status
        $demandManager->delete($demand);
    }

    /**
     * @param $playerId
     *
     * @throws \Exception
     */
    // TODO @querdos: API DOC
    public function removePlayerFromTeamAction($playerId)
    {
        /** @var PlayerManager $playerManager */
        $playerManager = $this->get('challengeme.manager.player');
        /** @var Player $player */
        $player = $playerManager->readById($playerId);
        /** @var Team $team */
        $team = $player->getTeam();

        // retreiving current user
        $user = $this->get('security.token_storage')->getToken()->getUser();

        // checking user
        if ($user->getUsername() !== $team->getLeader()->getUsername()) {
            throw new \Exception("You are not allowed to perform this operation");
        }

        // TODO @querdos: Finish the removePlayerFromTeam method
    }
}