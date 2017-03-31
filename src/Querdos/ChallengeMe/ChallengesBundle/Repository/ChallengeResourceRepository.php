<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/24/17
 * Time: 10:51 AM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ChallengeResourceRepository extends EntityRepository 
{
    /**
     * Return the list of resources for all challenges
     * (used when restoring database)
     *
     * @return array
     */
    public function resourcesForAll()
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('challenge_resource.resourceName as resource')
            ->from('ChallengesBundle:ChallengeResource', 'challenge_resource')

            ->where('challenge_resource.resourceName IS NOT NULL')
        ;

        $results = $query
            ->getQuery()
            ->getArrayResult()
        ;

        $data = [];
        foreach ($results as $result) {
            $data[] = $result['resource'];
        }

        return $data;
    }
}