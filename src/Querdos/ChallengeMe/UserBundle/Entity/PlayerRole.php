<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/18/17
 * Time: 12:13 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Entity;


class PlayerRole
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
     * @var Team
     */
    private $team;

    /**
     * PlayerRole constructor.
     *
     * @param string $name
     * @param Team   $team
     */
    public function __construct($name = "", Team $team = null)
    {
        $this->name   = $name;
        $this->team = $team;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function setTeam(Team $team)
    {
        $this->team = $team;
        return $this;
    }
}