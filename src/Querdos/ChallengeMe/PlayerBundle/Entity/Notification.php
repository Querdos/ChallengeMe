<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 3/22/17
 * Time: 5:58 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Entity;


use Querdos\ChallengeMe\UserBundle\Entity\Player;

class Notification
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Player
     */
    private $player;

    /**
     * @var bool
     */
    private $state;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * Notification constructor.
     * @param string $content
     * @param Player $player
     */
    public function __construct($content = "", Player $player = null)
    {
        $this->content = $content;
        $this->player = $player;
        $this->state = false;
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
     * @return Notification
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Notification
     */
    public function setContent($content)
    {
        $this->content = $content;
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
     * @return Notification
     */
    public function setPlayer($player)
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return bool
     */
    public function isState()
    {
        return $this->state;
    }

    /**
     * @param bool $state
     *
     * @return Notification
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return Notification
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }
}