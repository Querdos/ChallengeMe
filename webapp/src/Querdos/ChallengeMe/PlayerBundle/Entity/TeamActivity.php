<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/27/17
 * Time: 3:44 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Entity;


use Querdos\ChallengeMe\UserBundle\Entity\Team;

class TeamActivity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Team
     */
    private $team;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * TeamActivity constructor.
     *
     * @param string $title
     * @param string $description
     * @param Team   $team
     */
    public function __construct($title = null, $description = null, Team $team = null)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->team        = $team;
        $this->date        = new \DateTime();
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
     * @return TeamActivity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return TeamActivity
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return TeamActivity
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return TeamActivity
     */
    public function setTeam(Team $team)
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
     * @return TeamActivity
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
}