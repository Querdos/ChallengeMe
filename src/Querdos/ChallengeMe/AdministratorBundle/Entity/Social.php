<?php
/**
 * Created by Hamza ESSAYEGH
 * Date: 8/15/16
 * Time: 1:18 PM
 */
namespace Querdos\ChallengeMe\AdministratorBundle\Entity;

/**
 * Class Social
 * @package Querdos\ChallengeMe\AdministratorBundle\Entity
 */
class Social
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var
     */
    private $logo;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $link;

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
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     *
     * @return $this;
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

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
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return $this;
     */
    public function setLink($link)
    {
        $this->link = $link;

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
