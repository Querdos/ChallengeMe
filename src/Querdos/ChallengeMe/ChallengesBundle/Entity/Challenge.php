<?php

namespace Querdos\ChallengeMe\ChallengesBundle\Entity;

use Querdos\ChallengeMe\UserBundle\Entity\Administrator;

/**
 * Challenge
 */
class Challenge
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $points;

    /**
     * @var int
     */
    private $level;

    /**
     * @var string
     */
    private $statement;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var Administrator
     */
    private $author;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var string
     */
    private $solution;

    /**
     * Challenge constructor.
     *
     * @param string        $title
     * @param string        $description
     * @param int           $points
     * @param int           $level
     * @param string        $statement
     * @param Category      $category
     * @param Administrator $author
     */
    public function __construct($title = "", $description = "", $points = 0, $level = 0, $statement = "", Category $category = null, Administrator $author = null)
    {
        $this->title       = $title;
        $this->description = $description;
        $this->points      = $points;
        $this->level       = $level;
        $this->statement   = $statement;
        $this->category    = $category;
        $this->author      = $author;
        $this->created     = new \DateTime();
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
     * Set title
     *
     * @param string $title
     *
     * @return Challenge
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return Challenge
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Challenge
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Challenge
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set statement
     *
     * @param string $statement
     *
     * @return Challenge
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;

        return $this;
    }

    /**
     * Get statement
     *
     * @return string
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return Administrator
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Administrator $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return string
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * @param string $solution
     *
     * @return Challenge
     */
    public function setSolution($solution)
    {
        $this->solution = $solution;
        return $this;
    }
}

