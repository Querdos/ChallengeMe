<?php
/**
* Created by Hamza ESSAYEGH
* Date: 11/14/16
* Time: 01:41 PM
*/

namespace Querdos\ChallengeMe\UserBundle\Entity;

abstract class BaseUser
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $emailBack;

    /**
     * @var InfoUser
     */
    protected $infoUser;

    /**
     * @var \DateTime
     */
    protected $creationDate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmailBack()
    {
        return $this->emailBack;
    }

    /**
     * @param string $emailBack
     *
     * @return $this
     */
    public function setEmailBack($emailBack)
    {
        $this->emailBack = $emailBack;
        return $this;
    }

    /**
     * @return InfoUser
     */
    public function getInfoUser()
    {
        return $this->infoUser;
    }

    /**
     * @param InfoUser $infoUser
     *
     * @return $this
     */
    public function setInfoUser(InfoUser $infoUser)
    {
        $this->infoUser = $infoUser;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     *
     * @return $this
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }
}