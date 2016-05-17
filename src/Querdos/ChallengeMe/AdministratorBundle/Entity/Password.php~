<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Password
 *
 * @ORM\Table(name="password")
 * @ORM\Entity(repositoryClass="Querdos\ChallengeMe\AdministratorBundle\Repository\PasswordRepository")
 */
class Password
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="encrypted", type="string", length=255)
     */
    private $encrypted;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;


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
     * Set encrypted
     *
     * @param string $encrypted
     *
     * @return Password
     */
    public function setEncrypted($encrypted)
    {
        $this->encrypted = $encrypted;

        return $this;
    }

    /**
     * Get encrypted
     *
     * @return string
     */
    public function getEncrypted()
    {
        return $this->encrypted;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Password
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }
}
