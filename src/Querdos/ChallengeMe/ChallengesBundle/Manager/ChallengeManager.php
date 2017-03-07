<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 28/02/17
 * Time: 12:08
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Manager;


use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
use Querdos\ChallengeMe\ChallengesBundle\Repository\ChallengeRepository;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;

class ChallengeManager
{
    /**
     * @var ChallengeRepository $repository
     */
    private $repository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Create a new challenge in database
     *
     * @param Challenge $challenge
     */
    public function create(Challenge $challenge)
    {
        $this->entityManager->persist($challenge);
        $this->entityManager->flush($challenge);
    }

    /**
     * Update an existing challenge in database
     *
     * @param Challenge $challenge
     */
    public function update(Challenge $challenge)
    {
        // retrieving unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();

        // checking if persisted
        if (!$unitOfWork->isEntityScheduled($challenge)) {
            $this->entityManager->persist($challenge);
        }

        // flushing
        $this->entityManager->flush($challenge);
    }

    /**
     * Remove an existing challenge from database
     *
     * @param Challenge $challenge
     */
    public function delete(Challenge $challenge)
    {
        $this->entityManager->remove($challenge);
        $this->entityManager->flush($challenge);
    }

    /**
     * Retrieve all existing challenges from database
     *
     * @return Challenge[]
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * Retreive a specific challenge with the given id
     *
     * @param int $challenge_id
     *
     * @return Challenge
     */
    public function readById($challenge_id)
    {
        return $this->repository->findOneById($challenge_id);
    }

    /**
     * Retrieve all challenges by author
     *
     * @param Administrator $administrator
     *
     * @return Challenge[]
     */
    public function readByAuthor(Administrator $administrator)
    {
        return $this->repository->findByAdministrator($administrator);
    }

    /**
     * Retrieve all challenges by categories
     *
     * @param Category $category
     *
     * @return Challenge[]
     */
    public function readByCategory(Category $category)
    {
        return $this->repository->findByCategory($category);
    }

    /**
     * Set the repository
     *
     * @param ChallengeRepository $repository
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