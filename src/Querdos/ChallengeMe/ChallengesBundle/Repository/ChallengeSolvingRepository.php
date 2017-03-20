<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/20/17
 * Time: 3:33 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\ChallengesBundle\Entity\ChallengeSolving;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class ChallengeSolvingRepository extends EntityRepository
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
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('challenge_solving')
            ->from('ChallengesBundle:ChallengeSolving', 'challenge_solving')

            ->join('challenge_solving.team', 'team')
            ->where('team = :team')

            ->setParameter('team', $team)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}