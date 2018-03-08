<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 12:20 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Manager;


use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;

class ChallengeResourceManager extends BaseManager
{
    /**
     * Return the list of resource(s) for the given challenge
     *
     * @param Challenge $challenge
     */
    public function readByChallenge(Challenge $challenge)
    {
        return $this->repository->findByChallenge($challenge);
    }

    /**
     * Return the list of resources for all teams
     * (used when restoring database)
     *
     * @return array
     */
    public function getResourcesForAll()
    {
        return $this->repository->resourcesForAll();
    }
}