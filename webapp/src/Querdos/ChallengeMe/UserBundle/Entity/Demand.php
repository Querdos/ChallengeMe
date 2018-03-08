<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/15/17
 * Time: 3:22 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Entity;

class Demand
{
    const STATUS_WAITING  = 0;
    const STATUS_DECLINED = 1;
    const STATUS_ACCEPTED = 2;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Player
     */
    private $player;

    /**
     * @var Team
     */
    private $team;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var int
     */
    private $status;

    /**
     * Demand constructor.
     *
     * @param Player $player
     * @param Team   $team
     * @param int    $status
     *
     */
    public function __construct(Player $player = null, Team $team = null, $status = 0)
    {
        $this->player = $player;
        $this->team   = $team;
        $this->status = $status;

        $this->date   = new \DateTime();
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
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     *
     * @return $this
     */
    public function setTeam($team)
    {
        $this->team = $team;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function isStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    
}