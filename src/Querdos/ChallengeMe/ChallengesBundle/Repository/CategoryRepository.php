<?php

namespace Querdos\ChallengeMe\ChallengesBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Return the count of existing categories
     *
     * @return int
     */
    public function getCategoryCount()
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('COUNT(cat)')

            ->from('ChallengesBundle:Category', 'cat')
        ;

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
