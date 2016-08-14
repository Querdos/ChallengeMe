<?php
/**
 * Created by Hamza ESSAYEGH
 * Date: 11/14/16
 * Time: 01:41 PM
 */
namespace Querdos\ChallengeMe\AdministratorBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Moderator
 */
class Moderator implements UserInterface, \Serializable
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
    private $plainPassword;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $emailBack;

    /**
     * @var InfoUser
     */
    private $infoUser;

    public function __construct($id = "", $username = "", $email = "", $password = "")
    {
        $this->id           = $id;
        $this->username     = $username;
        $this->email        = $email;
        $this->emailBack    = "";
        $this->password     = $password;

        $this->infoUser     = new InfoUser();
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
     * @return Moderator
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
     * @return Moderator
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
     * @return Moderator
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
     * @return Moderator
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
     * Check if the username and the given password are different
     *
     * @return true if password and username are different
     */
    public function isPasswordDifferentFromUsername()
    {
        return $this->username !== $this->plainPassword;
    }

    /**
     * Check if email and email back are different
     * @return true if emails are different
     */
    public function isEmailCorrect()
    {
        return $this->email !== $this->emailBack;
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
        return array('ROLE_MODERATOR');
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
        $this->plainPassword = "";
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param   string  $plainPassword
     * @return          $this
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
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
     * @param   InfoUser    $infoUser
     * @return              $this
     */
    public function setInfoUser($infoUser)
    {
        $this->infoUser = $infoUser;

        return $this;
    }
}
