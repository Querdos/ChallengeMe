<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/27/17
 * Time: 2:18 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Manager;


use Querdos\ChallengeMe\PlayerBundle\Entity\PlayerActivity;
use Querdos\ChallengeMe\UserBundle\Entity\Player;

class PlayerActivityManager extends BaseManager
{
    /**
     * Return recent activities for the given player (5 max)
     *
     * @param Player $player
     *
     * @return PlayerActivity[]
     */
    public function readForPlayer(Player $player)
    {
        return $this->repository->readForPlayer($player);
    }
}