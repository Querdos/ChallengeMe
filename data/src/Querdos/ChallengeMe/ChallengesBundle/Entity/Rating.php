<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/21/17
 * Time: 4:28 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Entity;

use Querdos\ChallengeMe\UserBundle\Entity\Player;

class Rating
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Challenge
     */
    private $challenge;

    /**
     * @var Player
     */
    private $player;

    /**
     * @var int
     */
    private $mark;

    /**
     * Rating constructor.
     *
     * @param Challenge $challenge
     * @param Player    $player
     * @param int       $mark
     */
    public function __construct(Challenge $challenge = null, Player $player = null, $mark = 0)
    {
        $this->challenge = $challenge;
        $this->player    = $player;
        $this->mark      = $mark;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Challenge
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * @param Challenge $challenge
     *
     * @return $this
     */
    public function setChallenge($challenge)
    {
        $this->challenge = $challenge;
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param Player $player
     *
     * @return $this
     */
    public function setPlayer($player)
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return int
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param int $mark
     *
     * @return $this
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
        return $this;
    }
}