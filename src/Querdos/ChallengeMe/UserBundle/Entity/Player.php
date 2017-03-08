<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/8/17
 * Time: 9:49 AM
 */

namespace Querdos\ChallengeMe\UserBundle\Entity;


use Symfony\Component\Security\Core\User\UserInterface;

class Player extends BaseUser implements UserInterface, \Serializable
{

    /**
     * Administrator constructor.
     *
     * @param string $id
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct($id = "", $username = "", $email = "", $password = "")
    {
        $this->id           = $id;
        $this->username     = $username;
        $this->email        = $email;
        $this->emailBack    = "";
        $this->password     = $password;
        $this->creationDate = new \DateTime();

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
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return array(Role::ROLE_USER);
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
}