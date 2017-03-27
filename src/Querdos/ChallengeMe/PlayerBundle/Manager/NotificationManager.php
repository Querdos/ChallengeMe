<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 3/22/17
 * Time: 6:14 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Manager;


use Querdos\ChallengeMe\PlayerBundle\Entity\Notification;
use Querdos\ChallengeMe\PlayerBundle\Repository\NotificationRepository;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class NotificationManager extends BaseManager
{
    /**
     * Send a notification for all players in the team
     *
     * @param Team $team
     * @param $content
     */
    public function sendForTeam(Team $team, $content)
    {
        foreach ($team->getPlayers() as $player) {
            $notification = new Notification(
                $content, $player
            );
            $this->create($notification);
        }
    }
    
    /**
     * Return all notifications for the given player
     *
     * @param Player $player
     * @return Notification[]
     */
    public function getForPlayer(Player $player)
    {
        return $this->repository->readForPlayer($player);
    }
    
    /**
     * @param Player $player
     *
     * @return Notification[]
     */
    public function getUnreadForPlayer(Player $player)
    {
        return $this->repository->getUnreadForPlayer($player);
    }

    /**
     * Return count of unread notifications for player
     *
     * @param Player $player
     *
     * @return int
     */
    public function getUnreadCountForPlayer(Player $player)
    {
        return $this->repository->getUnreadCountaForPlayer($player);
    }
}