<?php
/**
 * Created by Hamza ESSAYEGH
 * Date: 8/15/16
 * Time: 1:14 PM
 */
namespace Querdos\ChallengeMe\AdministratorBundle\Entity;

/**
 * Class PersonalInformation
 * @package Querdos\ChallengeMe\AdministratorBundle\Entity
 */
class PersonalInformation
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $job;

    /**
     * @var string
     */
    private $website;

    /**
     * @var Skill[]
     */
    private $skills;

    /**
     * @var Social[]
     */
    private $socials;

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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return $this;
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param string $job
     *
     * @return $this;
     */
    public function setJob($job)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     *
     * @return $this;
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return Skill[]
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Add skill to the current list
     *
     * @param Skill $skill
     *
     * @return $this
     */
    public function addSkill(Skill $skill)
    {
        $this->skills[] = $skill;
        return $this;
    }

    /**
     * @return Social[]
     */
    public function getSocials()
    {
        return $this->socials;
    }

    /**
     * Add a social to the current list
     *
     * @param Social $social
     *
     * @return $this
     */
    public function addSocial(Social $social)
    {
        $this->socials[] = $social;
        return $this;
    }

    /**
     * Set skills
     *
     * @param $skills
     *
     * @return $this
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
        return $this;
    }

    /**
     * Set social
     *
     * @param $socials
     *
     * @return $this
     */
    public function setSocials($socials)
    {
        $this->socials = $socials;
        return $this;
    }

}
