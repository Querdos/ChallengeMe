<?php

namespace Querdos\ChallengeMe\AdministratorBundle\Entity;

use DateTime;

/**
 * InfoUser
 */
class InfoUser
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var \DateTime
     */
    private $birthday;

    /**
     * @var string
     * TODO : Create preferences entity
     */
    private $locale;

    /**
     * @var PersonalInformation
     */
    private $personalInformation;

    /**
     * InfoUser constructor.
     *
     * @param string    $firstname
     * @param string    $lastname
     * @param string    $locale
     * @param DateTime  $birthday
     */
    public function __construct($firstname = "", $lastname = "", $locale = "en", $birthday = null)
    {
        $this->firstName    = $firstname;
        $this->lastName     = $lastname;
        $this->locale       = $locale;
        $this->birthday     = new DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return InfoUser
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return InfoUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return InfoUser
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Check if the birthday date is correct
     * @return true if the birthday is lower than today
     */
    public function isBirthdayCorrect()
    {
        return $this->birthday < (new \DateTime());
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return $this;
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
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
