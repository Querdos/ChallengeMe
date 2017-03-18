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
     * @var Player
     */
    private $player;

    /**
     * PlayerRole constructor.
     *
     * @param string $name
     * @param Player $player
     */
    public function __construct($name = "", Player $player = null)
    {
        $this->name   = $name;
        $this->player = $player;
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
}