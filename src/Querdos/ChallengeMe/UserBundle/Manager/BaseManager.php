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
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * Create a new entity in database
     *
     * @param $entity
     */
    public function create($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush($entity);
    }

    /**
     * Update an existing entity and persist it in database
     *
     * @param $entity
     */
    public function update($entity)
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
    public function delete($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush($entity);
    }

    /**
     * Return all existing entities from database
     *
     * @return array
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * Return an entity with a given ID
     *
     * @param $id
     *
     * @return mixed
     */
    public function readById($id)
    {
        return $this->repository->findOneById($id);
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