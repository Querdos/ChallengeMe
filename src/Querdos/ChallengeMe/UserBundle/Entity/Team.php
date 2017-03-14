<?php

namespace Querdos\ChallengeMe\UserBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Team
 * @Vich\Uploadable
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
     * @Vich\UploadableField(mapping="team_avatar", fileNameProperty="avatarName")
     *
     * @var File
     */
    private $avatar;

    /**
     * @var string
     */
    private $avatarName;

    /**
     * @var \DateTime
     */
    private $updatedAt;

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

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return $this
     */
    public function setAvatar(File $file = null)
    {
        $this->avatar = $file;
        if ($file) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return File | null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param $name
     *
     * @return Team
     */
    public function setAvatarName($name)
    {
        $this->avatarName = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvatarName()
    {
        return $this->avatarName;
    }
}
