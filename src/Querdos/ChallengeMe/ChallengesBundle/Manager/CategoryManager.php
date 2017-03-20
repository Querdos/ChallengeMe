<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/20/17
 * Time: 3:46 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Manager;


class CategoryManager extends BaseManager
{
    /**
     * Return the count of existing categories
     *
     * @return int
     */
    public function count()
    {
        return $this->repository->getCategoryCount();
    }
}