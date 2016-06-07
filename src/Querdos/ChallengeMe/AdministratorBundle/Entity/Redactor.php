<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Redactor
 */
class Redactor implements UserInterface, \Serializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $emailBack;

    public function __construct($id = "", $username = "", $email = "", $password = "")
    {
        $this->id           = $id;
        $this->username     = $username;
        $this->email        = $email;
        $this->emailBack    = "";
        $this->password     = $password;

        $this->infoUser = new InfoUser();
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
     * Set username
     *
     * @param string $username
     *
     * @return Redactor
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Redactor
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Redactor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set emailBack
     *
     * @param string $emailBack
     *
     * @return Redactor
     */
    public function setEmailBack($emailBack)
    {
        $this->emailBack = $emailBack;

        return $this;
    }

    /**
     * Get emailBack
     *
     * @return string
     */
    public function getEmailBack()
    {
        return $this->emailBack;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return array('ROLE_REDACTOR');
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt() {}

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->plainPassword = '';
    }
    /**
     * @var \Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser
     */
    private $infoUser;


    /**
     * Set infoUser
     *
     * @param \Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser $infoUser
     *
     * @return Redactor
     */
    public function setInfoUser(\Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser $infoUser = null)
    {
        $this->infoUser = $infoUser;

        return $this;
    }

    /**
     * Get infoUser
     *
     * @return \Querdos\ChallengeMe\AdministratorBundle\Entity\InfoUser
     */
    public function getInfoUser()
    {
        return $this->infoUser;
    }
}
