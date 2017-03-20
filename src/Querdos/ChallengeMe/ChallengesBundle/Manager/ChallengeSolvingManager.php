<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/20/17
 * Time: 3:47 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Manager;


use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
use Querdos\ChallengeMe\ChallengesBundle\Entity\ChallengeSolving;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class ChallengeSolvingManager extends BaseManager
{
    /**
     * Retrieve an unfinished challenge for the given team
     *
     * @param Team $team
     *
     * @return ChallengeSolving|null
     */
    public function getChallengeInProgress(Team $team)
    {
        return $this->repository->getChallengeInProgress($team);
    }

    /**
     * Start a challenge for the given team
     *
     * @param Challenge $challenge
     * @param Team      $team
     *
     * @throws \Exception
     */
    public function startChallenge(Challenge $challenge, Team $team)
    {
        // first of all, checking that no other challenge has been started
        if (null !== $this->getChallengeInProgress($team)) {
            throw new \Exception("A challenge is already in progress for this team");
        }

        // new challenge object
        $challengeSolving = new ChallengeSolving($team, $challenge);

        // persiting
        $this->create($challengeSolving);
    }
}