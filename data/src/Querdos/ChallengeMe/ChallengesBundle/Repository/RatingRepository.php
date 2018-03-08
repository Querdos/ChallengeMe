<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/21/17
 * Time: 4:30 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
use Symfony\Component\VarDumper\VarDumper;

class RatingRepository extends EntityRepository
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
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('rating.mark')
            ->from('ChallengesBundle:Rating', 'rating')

            ->join('rating.challenge', 'challenge')
            ->where('challenge = :challenge')

            ->setParameter('challenge', $challenge)
        ;

        $results = $query->getQuery()->getResult();
        if (count($results) == 0) {
            return 0;
        }

        $note = 0;
        foreach ($results as $result) {
            $note += $result["mark"];
        }
        $note /= count($results);

        return intval(floor($note));
    }
}