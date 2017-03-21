<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/21/17
 * Time: 4:38 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Manager;


use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;

class RatingManager extends BaseManager
{
    /**
     * Return the global note for the given challenge
     *
     * @param Challenge $challenge
     *
     * @return int
     */
    public function noteForChallenge(Challenge $challenge)
    {
        return $this->repository->noteForChallenge($challenge);
    }
}