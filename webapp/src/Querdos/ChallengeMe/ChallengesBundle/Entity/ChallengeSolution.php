<?php
/**
 * Created by PhpStorm.
 * User: querdos
 * Date: 3/24/17
 * Time: 9:06 AM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Entity;


class ChallengeSolution
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * ChallengeSolution constructor.
     *
     * @param string $content
     */
    public function __construct($content = "")
    {
        $this->content = $content;
    }


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
     * @return ChallengeSolution
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return ChallengeSolution
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}