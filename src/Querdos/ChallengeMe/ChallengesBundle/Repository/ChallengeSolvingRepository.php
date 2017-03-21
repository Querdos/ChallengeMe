<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/20/17
 * Time: 3:33 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;
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
            ->addSelect('team')
            ->addSelect('challenge')

            ->from('ChallengesBundle:ChallengeSolving', 'challenge_solving')

            ->join('challenge_solving.team', 'team')
            ->join('challenge_solving.challenge', 'challenge')

            ->where('team = :team')
            ->andWhere('challenge_solving.state = 0')

            ->setParameter('team', $team)
        ;

        return $query
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Retrieve the list of challenges solved by the given team
     *
     * @param Team $team
     *
     * @return array
     */
    public function getChallengesSolved(Team $team)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('challenge.id')
            ->from('ChallengesBundle:ChallengeSolving', 'chal_sol')

            ->join('chal_sol.team', 'team')
            ->join('chal_sol.challenge', 'challenge')

            ->where('team = :team')
            ->andWhere('chal_sol.state = 1') // state must be true

            ->setParameter('team', $team)
        ;

        $results = $query
            ->getQuery()
            ->getArrayResult()
        ;

        $toReturn = array();
        foreach ($results as $result) {
            $toReturn[] = $result['id'];
        }

        return $toReturn;
    }

    /**
     * Return the count of solved challenges for the given category
     *
     * @param Team     $team
     * @param Category $category
     *
     * @return int
     */
    public function completedChallengesForCategory(Team $team, Category $category)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('COUNT(chal_solv)')
            ->from('ChallengesBundle:ChallengeSolving', 'chal_solv')

            ->join('chal_solv.team', 'team')
            ->join('chal_solv.challenge', 'challenge')

            ->where('team = :team')
            ->andWhere('chal_solv.state = 1')
            ->andWhere('challenge.category = :category')

            ->setParameter('team', $team)
            ->setParameter('category', $category)
        ;

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}