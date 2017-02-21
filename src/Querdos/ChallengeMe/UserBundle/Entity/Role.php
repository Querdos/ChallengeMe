<?php
/**
 * Created by Hamza ESSAYEGH.
 * Date: 6/5/16
 * Time: 12:18 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Entity;

/**
 * Role
 */
class Role
{
    const ROLE_ADMIN        = "ROLE_ADMIN";
    const ROLE_MODERATOR    = "ROLE_MODERATOR";
    const ROLE_REDACTOR     = "ROLE_REDACTOR";
    const ROLE_USER         = "ROLE_USER";

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $value;

    /**
     * Role constructor.
     *
     * @param string $value
     */
    public function __construct($value = '')
    {
        $this->value = $value;
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
     * Set value
     *
     * @param string $value
     *
     * @return Role
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}

