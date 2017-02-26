<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 26/02/17
 * Time: 15:16
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Manager;


use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;
use Querdos\ChallengeMe\ChallengesBundle\Repository\CategoryRepository;

class CategoryManager
{
    /**
     * @var CategoryRepository $repository
     */
    private $repository;

    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * Create a new category in database
     *
     * @param Category $category
     */
    public function create(Category $category)
    {
        // persisting and flushing
        $this->entityManager->persist($category);
        $this->entityManager->flush($category);
    }

    /**
     * Update an existing category in database
     *
     * @param Category $category
     */
    public function update(Category $category)
    {
        // retrieving unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();

        // Checking if scheduled
        if (!$unitOfWork->isEntityScheduled($category)) {
            $this->entityManager->persist($category);
        }

        // flushing
        $this->entityManager->flush($category);
    }

    /**
     * Delete a category from database
     *
     * @param Category $category
     */
    public function delete(Category $category)
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush($category);
    }

    /**
     * Set the repository
     *
     * @param CategoryRepository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * Set the entity manager
     *
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }
}