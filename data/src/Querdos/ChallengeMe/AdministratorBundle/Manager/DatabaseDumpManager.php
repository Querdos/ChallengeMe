<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/29/17
 * Time: 11:42 AM
 */

namespace Querdos\ChallengeMe\AdministratorBundle\Manager;

use Querdos\ChallengeMe\AdministratorBundle\Entity\DatabaseDump;

class DatabaseDumpManager extends BaseManager
{
    /**
     * Return all database dumps ordered by date
     *
     * @return DatabaseDump[]
     */
    public function all()
    {
        return $this->repository->all();
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