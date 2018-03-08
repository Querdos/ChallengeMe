<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/29/17
 * Time: 11:27 AM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\AdministratorBundle\Entity\DatabaseDump;

class DatabaseDumpRepository extends EntityRepository
{
    /**
     * Return all database dumps ordered by date
     *
     * @return DatabaseDump[]
     */
    public function all()
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('database_dump')
            ->from('AdminBundle:DatabaseDump', 'database_dump')

            ->orderBy('database_dump.updatedAt', 'DESC')
        ;

        return $query
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return the list of resources for all teams
     * (used when restoring database)
     *
     * @return array
     */
    public function resourcesForAll()
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('database_dump.dumpFileName as resource')
            ->from('AdminBundle:DatabaseDump', 'database_dump')

            ->where('database_dump.dumpFileName IS NOT NULL')
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