<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/9/17
 * Time: 1:40 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class BaseManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * Create a new entity in database
     *
     * @param $entity
     */
    protected function create($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush($entity);
    }

    /**
     * Update an existing entity and persist it in database
     *
     * @param $entity
     */
    protected function update($entity)
    {
        // retrieving unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();

        // checking if entity is persisted
        if (!$unitOfWork->isEntityScheduled($entity)) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush($entity);
    }

    /**
     * Delete an existing entity in database
     *
     * @param $entity
     */
    protected function delete($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush($entity);
    }

    /**
     * Set the entity manager
     *
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Set the entity repository
     *
     * @param EntityRepository $repository
     */
    public function setRepository(EntityRepository $repository)
    {
        $this->repository = $repository;
    }
}