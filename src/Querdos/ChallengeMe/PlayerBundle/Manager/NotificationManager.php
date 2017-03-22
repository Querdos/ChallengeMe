<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 3/22/17
 * Time: 6:14 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Manager;


use Querdos\ChallengeMe\PlayerBundle\Entity\Notification;
use Querdos\ChallengeMe\UserBundle\Entity\Player;

class NotificationManager extends BaseManager
{
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
}