<?php
/**
 * Created by Hamza ESSAYEGH
 * Date: 8/15/16
 * Time: 1:16 PM
 */
namespace Querdos\ChallengeMe\UserBundle\Entity;

/**
 * Class Skill
 * @package Querdos\ChallengeMe\AdministratorBundle\Entity
 */
class Skill
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $level;

    /**
     * @var PersonalInformation
     */
    private $personalInformation;

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
     * @return $this;
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this;
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int $level
     *
     * @return $this;
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return PersonalInformation
     */
    public function getPersonalInformation()
    {
        return $this->personalInformation;
    }

    /**
     * @param PersonalInformation $personalInformation
     *
     * @return $this;
     */
    public function setPersonalInformation($personalInformation)
    {
        $this->personalInformation = $personalInformation;
        return $this;
    }
}
