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

class ChallengeManager extends BaseManager
{
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
     * Return the count of existing challenges
     *
     * @param Category|null $category
     *
     * @return int
     */
    public function count(Category $category = null)
    {
        return $this->repository->getChallengesCount($category);
    }
}