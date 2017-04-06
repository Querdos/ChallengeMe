<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 4/6/17
 * Time: 11:21 AM
 */

namespace Querdos\ChallengeMe\UserBundle\Entity;


class PasswordTokenReset
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    /**
     * @var Player
     */
    private $player;

    /**
     * @var \DateTime
     */
    private $expiration_date;

    /**
     * PasswordTokenReset constructor.
     *
     * @param string    $value
     * @param Player    $player
     * @param \DateTime $expiration_date
     */
    public function __construct($value = null, Player $player = null, \DateTime $expiration_date = null)
    {
        $this->value           = $value;
        $this->player          = $player;
        $this->expiration_date = $expiration_date;
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
     * @return PasswordTokenReset
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return PasswordTokenReset
     */
    public function setValue($value)
    {
        $this->value = $value;
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
     * @return PasswordTokenReset
     */
    public function setPlayer($player)
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpirationDate()
    {
        return $this->expiration_date;
    }

    /**
     * @param \DateTime $expiration_date
     *
     * @return PasswordTokenReset
     */
    public function setExpirationDate($expiration_date)
    {
        $this->expiration_date = $expiration_date;
        return $this;
    }

}