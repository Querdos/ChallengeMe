<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/15/17
 * Time: 3:41 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\PlayerBundle\Entity\Notification;
use Querdos\ChallengeMe\PlayerBundle\Entity\PlayerActivity;
use Querdos\ChallengeMe\PlayerBundle\Manager\NotificationManager;
use Querdos\ChallengeMe\PlayerBundle\Manager\PlayerActivityManager;
use Querdos\ChallengeMe\UserBundle\Entity\Demand;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class DemandManager extends BaseManager
{
    /**
     * @var PlayerManager $playerManager
     */
    private $playerManager;

    /**
     * @var NotificationManager $notificationManager
     */
    private $notificationManager;

    /**
     * @var PlayerActivityManager
     */
    private $playerActivityManager;

    /**
     * @param Demand $demand
     */
    public function create($demand)
    {
        // extending parent method
        parent::create($demand);

        // sending a notification to the leader
        // TODO @querdos: Manage translation for a new demand, sent to the leader (notification)
        $this->notificationManager->create(
            new Notification(
                "You have a new demand for your team",
                $demand->getTeam()->getLeader()
            )
        );

        // sending notification to the player
        // TODO @querdos: Manage translation for a new demand, sent to the leader (notification)
        $this->notificationManager->create(
            new Notification(
                "Your demand has been sent",
                $demand->getPlayer()
            )
        );
    }

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

        // creating a new notification
        // TODO @querdos: Manage translation for an accepted demand (notification)
        $this->notificationManager->create(
            new Notification(
                "You have joined " . $demand->getTeam()->getName() . " !",
                $demand->getPlayer()
            )
        );

        // creating recent activity for the player
        // TODO @querdos: Manage translation for an accepted demand (notification)
        $this->playerActivityManager->create(
            new PlayerActivity(
                "Team joined",
                "You have joined " . $demand->getTeam()->getName(),
                $demand->getPlayer()
            )
        );
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

        // sending a notification to the player
        // TODO @querdos: Manage translation for a declined demand (notification)
        $this->notificationManager->create(
            new Demand(
                "The team " . $demand->getTeam()->getName() . " has declined your demand.",
                $demand->getPlayer()
            )
        );
    }

    /**
     * Return all demands for the given player (only waiting demands)
     *
     * @param Player $player
     *
     * @return Demand[]
     */
    public function allForPlayer(Player $player)
    {
        return $this->repository->allForPlayer($player);
    }

    /**
     * @param PlayerManager $playerManager
     */
    public function setPlayerManager($playerManager)
    {
        $this->playerManager = $playerManager;
    }

    /**
     * @param NotificationManager $notificationManager
     */
    public function setNotificationManager($notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param PlayerActivityManager $playerActivityManager
     *
     * @return DemandManager
     */
    public function setPlayerActivityManager($playerActivityManager)
    {
        $this->playerActivityManager = $playerActivityManager;
        return $this;
    }
}