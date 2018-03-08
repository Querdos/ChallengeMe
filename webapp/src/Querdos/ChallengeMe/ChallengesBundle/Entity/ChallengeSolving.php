<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/20/17
 * Time: 3:29 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Entity;


use Ivory\CKEditorBundle\Exception\Exception;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class ChallengeSolving
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Team
     */
    private $team;

    /**
     * @var Challenge
     */
    private $challenge;

    /**
     * @var \DateTime
     */
    private $date_start;

    /**
     * @var \DateTime
     */
    private $date_end;

    /**
     * @var int
     */
    private $duration;

    /**
     * True:    The concerned challenge has been solved
     * False:   The concerned challenge hasn't been solved
     *
     * @var bool
     */
    private $state;

    /**
     * ChallengeSolving constructor.
     *
     * @param Team      $team
     * @param Challenge $challenge
     * @param bool      $state
     */
    public function __construct(Team $team = null, Challenge $challenge = null, $state = false)
    {
        $this->team       = $team;
        $this->challenge  = $challenge;
        $this->date_start = new \DateTime();
        $this->state      = $state;
        $this->duration   = 0;
    }

    /**
     * Calculate the time taken to solve the challenge by the team
     *
     * @return int
     * @throws Exception
     */
    private function calculateDiff()
    {
        if (null === $this->date_end) {
            throw new Exception("Can't calculate duration without the date_end");
        }
        return ($this->date_end->getTimestamp() - $this->date_start->getTimestamp());
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
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     *
     * @return $this
     */
    public function setTeam($team)
    {
        $this->team = $team;
        return $this;
    }

    /**
     * @return Challenge
     */
    public function getChallenge()
    {
        return $this->challenge;
    }

    /**
     * @param Challenge $challenge
     *
     * @return $this
     */
    public function setChallenge($challenge)
    {
        $this->challenge = $challenge;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * @param \DateTime $date_start
     *
     * @return $this
     */
    public function setDateStart($date_start)
    {
        $this->date_start = $date_start;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * @param \DateTime $date_end
     *
     * @return $this
     */
    public function setDateEnd($date_end)
    {
        $this->date_end = $date_end;
        return $this;
    }

    /**
     * @return bool
     */
    public function isState()
    {
        return $this->state;
    }

    /**
     * @param bool $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return ChallengeSolving
     */
    public function setDuration()
    {
        $this->duration = ($this->date_end->getTimestamp() - $this->date_start->getTimestamp());
        return $this;
    }
}