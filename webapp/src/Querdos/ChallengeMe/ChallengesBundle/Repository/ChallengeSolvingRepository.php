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
use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
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

    /**
     * Get the count of teams who has solved the given challenge
     *
     * @param Challenge $challenge
     *
     * @return int
     */
    public function validationForChallenge(Challenge $challenge)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('COUNT(chal_solv)')
            ->from('ChallengesBundle:ChallengeSolving', 'chal_solv')

            ->join('chal_solv.challenge', 'challenge')

            ->where('challenge = :challenge')
            ->andWhere('chal_solv.state = 1') // state is true

            ->setParameter('challenge', $challenge)
        ;

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
     * Check if the given team has solved the given challenge
     *
     * @param Team      $team
     * @param Challenge $challenge
     *
     * @return bool
     */
    public function teamHasSolvedChallenge(Team $team, Challenge $challenge)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('chal_sol')
            ->from('ChallengesBundle:ChallengeSolving', 'chal_sol')

            ->join('chal_sol.team', 'team')
            ->join('chal_sol.challenge', 'challenge')

            ->where('team = :team')
            ->andWhere('challenge = :challenge')
            ->andWhere('chal_sol.state = 1')

            ->setParameter('team', $team)
            ->setParameter('challenge', $challenge)
        ;

        return null !== $query->getQuery()->getOneOrNullResult();
    }

    /**
     * Return the list of ranked team (by time) for the given challenge
     *
     * @param Challenge $challenge
     *
     * @return array
     */
    public function getRankedTeamsByChallenge(Challenge $challenge)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('team.name as team, TIME_TO_SEC(timediff(challengeSolving.date_end, challengeSolving.date_start)) as duration')
            ->from('ChallengesBundle:ChallengeSolving', 'challengeSolving')

            ->join('challengeSolving.team', 'team')
            ->join('challengeSolving.challenge', 'challenge')

            ->where('challenge = :challenge')
            ->orderBy('duration', 'DESC')

            ->setParameter('challenge', $challenge)
        ;

        return $query
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /**
     * Return the list of the 20 last teams that have solved challenges in the given category
     *
     * @param Category $category
     *
     * @return array
     */
    public function lastTeamsForCategory(Category $category)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('team.name as _team')
            ->addSelect('challenge.title as _challenge')
            ->addSelect('challengeSolving.date_end as _date_end')
            ->addSelect('challengeSolving.duration as _duration')

            ->from('ChallengesBundle:ChallengeSolving', 'challengeSolving')

            ->join('challengeSolving.challenge', 'challenge')
            ->join('challenge.category', 'category')
            ->join('challengeSolving.team', 'team')

            ->where('category = :category')
            ->orderBy('challengeSolving.date_end', 'DESC')

            ->setParameter('category', $category)

            ->setMaxResults(20)
        ;

        return $query
            ->getQuery()
            ->getArrayResult()
        ;
    }
}