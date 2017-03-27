<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/27/17
 * Time: 2:08 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Entity;


use Querdos\ChallengeMe\UserBundle\Entity\Player;

class PlayerActivity
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
     * @var Player
     */
    private $player;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * PlayerActivity constructor.
     *
     * @param string $title
     * @param string $description
     * @param Player $player
     */
    public function __construct($title = "", $description = "", Player $player = null)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->player      = $player;
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
     * @return PlayerActivity
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
     * @return PlayerActivity
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
     * @return PlayerActivity
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return PlayerActivity
     */
    public function setPlayer($player)
    {
        $this->player = $player;
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
     * @return PlayerActivity
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
}