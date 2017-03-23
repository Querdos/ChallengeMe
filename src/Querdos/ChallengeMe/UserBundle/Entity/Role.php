<?php
/**
 * Created by Hamza ESSAYEGH.
 * Author:  Querdos
 * Date:    6/5/16
 * Time:    12:18 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Entity;

/**
 * Role
 */
class Role
{
    /** Super admin role (TODO @querdos: See how it can be differed from normal admin) */
    const ROLE_SUPER_ADMIN  = "ROLE_SUPER_ADMIN";
    /** Administrator role */
    const ROLE_ADMIN        = "ROLE_ADMIN";
    /** Moderator role */
    const ROLE_MODERATOR    = "ROLE_MODERATOR";
    /** Redactor role */
    const ROLE_REDACTOR     = "ROLE_REDACTOR";
    /** User role */
    const ROLE_USER         = "ROLE_USER";

    /**
     * Check if a given value is an existing role
     * @param   string  $value
     * @return  bool    return true if $value is an existing role
     */
    public static function check($value)
    {
        if ($value === self::ROLE_ADMIN || $value === self::ROLE_MODERATOR || $value === self::ROLE_REDACTOR || $value === self::ROLE_USER) {
            return true;
        }

        return false;
    }

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

