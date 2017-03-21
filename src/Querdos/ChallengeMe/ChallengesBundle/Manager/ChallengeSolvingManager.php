<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/20/17
 * Time: 3:47 PM
 */

namespace Querdos\ChallengeMe\ChallengesBundle\Manager;


use Querdos\ChallengeMe\ChallengesBundle\Entity\Category;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
use Querdos\ChallengeMe\ChallengesBundle\Entity\ChallengeSolving;
use Querdos\ChallengeMe\UserBundle\Entity\Team;
use Symfony\Component\VarDumper\VarDumper;

class ChallengeSolvingManager extends BaseManager
{
    /**
     * @var CategoryManager
     */
    private $categoryManager;

    /**
     * @var ChallengeManager
     */
    private $challengeManager;

    /**
     * Retrieve an unfinished challenge for the given team
     *
     * @param Team $team
     *
     * @return ChallengeSolving|null
     */
    public function getChallengeInProgress(Team $team)
    {
        return $this->repository->getChallengeInProgress($team);
    }

    /**
     * Start a challenge for the given team
     *
     * @param Challenge $challenge
     * @param Team      $team
     *
     * @throws \Exception
     */
    public function startChallenge(Challenge $challenge, Team $team)
    {
        // first of all, checking that no other challenge has been started
        if (null !== $this->getChallengeInProgress($team)) {
            throw new \Exception("A challenge is already in progress for this team");
        }

        // new challenge object
        $challengeSolving = new ChallengeSolving($team, $challenge);

        // persiting
        $this->create($challengeSolving);
    }

    /**
     * Stopping the challenge for the given team
     *
     * @param Team $team
     */
    public function stopChallenge(Team $team)
    {
        // retrieving the challenge in progress for the team
        $challengeSolving = $this->getChallengeInProgress($team);

        // setting the date_end attribute and changing the state
        $challengeSolving
            ->setDateEnd(new \DateTime())
            ->setState(true)
        ;

        // persisting
        $this->update($challengeSolving);
    }

    /**
     * Retrieve the list of challenges solved by the given team
     *
     * @param Team $team
     *
     * @return array
     */
    public function getChallengesSolved(Team $team)
    {
        return $this->repository->getChallengesSolved($team);
    }

    /**
     * Return the count of solved challenges for the given category
     *
     * @param Team     $team
     * @param Category $category
     *
     * @return int
     */
    private function completedChallengesForCategory(Team $team, Category $category)
    {
        return $this->repository->completedChallengesForCategory($team, $category);
    }

    /**
     * Return challenges completion by the given team (by categories)
     *      [ 'category_name' => percentage, ... ]
     *
     * @param Team $team
     *
     * @return array
     */
    public function getChallengesCompletionForTeam(Team $team)
    {
        // retrieving all categories
        $categories = $this->categoryManager->all();

        // building the return array
        $completions = array();
        foreach($categories as $category) { /** @var Category $category */
            $total = $this->challengeManager->count($category);
            if (0 != $total) {
                $percentage = intval(
                    floor(
                        $this->completedChallengesForCategory($team, $category) * 100 / $total
                    )
                );
                $completions[$category->getTitle()] = $percentage;
            } else { // 0 means that there is no challenge yet for this category
                $completions[$category->getTitle()] = 0;
            }
        }

        return $completions;
    }

    /**
     * Return number of team that has solved the given challenge
     *
     * @param Challenge $challenge
     *
     * @return int
     */
    public function getValidationForChallenge(Challenge $challenge)
    {
        return $this->repository->validationForChallenge($challenge);
    }

    /**
     * @param CategoryManager $categoryManager
     */
    public function setCategoryManager($categoryManager)
    {
        $this->categoryManager = $categoryManager;
    }

    /**
     * @param ChallengeManager $challengeManager
     */
    public function setChallengeManager($challengeManager)
    {
        $this->challengeManager = $challengeManager;
    }
}