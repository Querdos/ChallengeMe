<?php

namespace Querdos\ChallengeMe\UserBundle\Entity;

/**
 * Team
 */
class Team
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $points;

    /**
     * @var Player[]
     */
    private $players;

    /**
     * @var Player
     */
    private $leader;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * Team constructor.
     *
     * @param string   $name
     * @param int      $points
     * @param Player[] $players
     * @param Player   $leader
     */
    public function __construct($name = "", $points = 0, array $players = null, Player $leader = null)
    {
        $this->name    = $name;
        $this->points  = $points;
        $this->players = $players;
        $this->leader  = $leader;

        $this->created = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return Team
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return Player[]
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Add a player to the team
     *
     * @param Player $player
     *
     * @return Team
     */
    public function addPlayer($player)
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Return the leader of the team
     *
     * @return Player
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * Set the leader of the team
     *
     * @param Player $leader
     *
     * @return Team
     */
    public function setLeader($leader)
    {
        $this->leader = $leader;
        return $this;
    }

    /**
     * Return the date cretion of the team
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the date creation of the team
     *
     * @param \DateTime $created
     *
     * @return Team
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }
}
