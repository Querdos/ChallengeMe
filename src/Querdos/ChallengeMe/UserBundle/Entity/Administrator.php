<?php
/**
 * Created by Hamza ESSAYEGH
 * Date: 11/14/16
 * Time: 01:41 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Entity;

use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
use Querdos\ChallengeMe\ChallengesBundle\Entity\ChallengeResource;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Adminstrator
 */
class Administrator extends BaseUser implements UserInterface, \Serializable
{
    /**
     * @var Role
     */
    private $role;

    /**
     * @var Challenge[]
     */
    private $challenges;

    /**
     * @var ChallengeResource
     */
    private $resources;

    /**
     * Administrator constructor.
     *
     * @param string $id
     * @param string $username
     * @param string $email
     * @param string $password
     * @param Role   $role
     */
    public function __construct($id = "", $username = "", $email = "", $password = "", Role $role = null)
    {
        $this->id           = $id;
        $this->username     = $username;
        $this->email        = $email;
        $this->emailBack    = "";
        $this->password     = $password;
        $this->creationDate = new \DateTime();

        $role == null ? $this->role = new Role() : $this->role = $role;
        $this->infoUser     = new InfoUser();
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
     * Check if email and email back are different
     * 
     * @return true if emails are different
     */
    public function isEmailCorrect()
    {
        return $this->email !== $this->emailBack;
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
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return array($this->role->getValue());
    }

    /**
     * @param Role $role
     *
     * @return $this
     */
    public function setRole(Role $role)
    {
        $this->role = $role;
        return $this;
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
        return $this;
    }

    /**
     * @param string $plainPassword
     * @return $this
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return Challenge[]
     */
    public function getChallenges()
    {
        return $this->challenges;
    }

    /**
     * @return ChallengeResource
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param ChallengeResource $resources
     *
     * @return Administrator
     */
    public function setResources($resources)
    {
        $this->resources = $resources;
        return $this;
    }
}
