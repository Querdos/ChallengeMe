<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/18/17
 * Time: 12:20 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Querdos\ChallengeMe\PlayerBundle\Entity\Notification;
use Querdos\ChallengeMe\PlayerBundle\Entity\TeamActivity;
use Querdos\ChallengeMe\PlayerBundle\Manager\NotificationManager;
use Querdos\ChallengeMe\PlayerBundle\Manager\TeamActivityManager;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\PlayerRole;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class PlayerRoleManager extends BaseManager
{
    /**
     * @var PlayerManager
     */
    private $playerManager;

    /**
     * @var TeamActivityManager
     */
    private $teamActivityManager;

    /**
     * @var NotificationManager
     */
    private $notificationManager;

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

    /**
     * Set a custom role for the given player
     *
     * @param PlayerRole $playerRole
     * @param Player     $player
     */
    public function setRoleForPlayer(PlayerRole $playerRole, Player $player)
    {
        // setting the role and updating
        $player->setPlayerRole($playerRole);
        $this->playerManager->update($player);

        // adding new activity for the team
        $this->teamActivityManager->create(
            new TeamActivity(
                "Role promotion",
                $player->getUsername() . " has been promoted to " . $playerRole->getName() . ".",
                $player->getTeam()
            )
        );

        // sending notification for the concerned player
        $this->notificationManager->create(
            new Notification(
                "You have been promoted to " . $playerRole->getName() . ".",
                $player
            )
        );

        // sending notification to the leader
        $this->notificationManager->create(
            new Notification(
                $player->getUsername() . " has been promoted.",
                $player->getTeam()->getLeader()
            )
        );
    }

    /**
     * @param PlayerManager $playerManager
     *
     * @return PlayerRoleManager
     */
    public function setPlayerManager($playerManager)
    {
        $this->playerManager = $playerManager;
        return $this;
    }

    /**
     * @param mixed $teamActivityManager
     *
     * @return PlayerRoleManager
     */
    public function setTeamActivityManager($teamActivityManager)
    {
        $this->teamActivityManager = $teamActivityManager;
        return $this;
    }

    /**
     * @param NotificationManager $notificationManager
     *
     * @return PlayerRoleManager
     */
    public function setNotificationManager($notificationManager)
    {
        $this->notificationManager = $notificationManager;
        return $this;
    }
}