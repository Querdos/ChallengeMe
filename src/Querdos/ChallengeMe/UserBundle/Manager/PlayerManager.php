<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/8/17
 * Time: 11:30 AM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\ChallengesBundle\Entity\Challenge;
use Querdos\ChallengeMe\ChallengesBundle\Manager\ChallengeSolvingManager;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\Team;
use Querdos\ChallengeMe\UserBundle\Repository\PlayerRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\VarDumper\VarDumper;

class PlayerManager extends BaseManager
{
    /**
     * @var PasswordEncoder
     */
    private $passwordEncoder;

    /**
     * @var ChallengeSolvingManager
     */
    private $challengeSolvingManager;

    /**
     * @var TeamManager
     */
    private $teamManager;

    /**
     * Create a new player in database
     *
     * @param Player $player
     */
    public function create($player)
    {
        // encoding the password and setting ti
        // erasing credential then
        $player
            ->setPassword(
                    $this->passwordEncoder->encodePassword(
                    $player,
                    $player->getPlainPassword()
                )
            )
            ->eraseCredentials()
        ;

        // heritage
        parent::create($player);
    }

    /**
     * Update an existing player in database
     *
     * @param Player $player
     */
    public function update($player)
    {
        // if the plain password is not empty <=> resetting
        if ("" !== $player->getPlainPassword() && null !== $player->getPlainPassword()) {
            $player
                ->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $player,
                        $player->getPlainPassword())
                )
                ->eraseCredentials()
            ;
        }

        // heritage
        parent::update($player);

        // flushing info user
        $this->entityManager->flush($player->getInfoUser());
    }

    /**
     * @param string $username
     *
     * @throws UsernameNotFoundException
     * @return null|Player
     */
    public function getPlayerData($username)
    {
        if (null === ($playerData = $this->repository->getPlayerData($username))){
            throw new UsernameNotFoundException(
                "Invalid credentials"
            );
        }

        return $playerData;
    }

    /**
     * Return the count of existing players in database
     *
     * @return int
     */
    public function count()
    {
        return $this->repository->getPlayerCount();
    }

    /**
     * @param PasswordEncoder $passwordEncoder
     */
    public function setPasswordEncoder($passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Check if the given solution is the correct one
     *
     * @param string    $solution
     * @param Challenge $challenge
     * @param Team      $team
     *
     * @return bool
     * @throws \Exception
     */
    public function checkSolution($solution, Challenge $challenge, Team $team)
    {
        // the solution is correct
        if ($solution === $challenge->getSolution()->getContent()) {
            // changing the status of the challenge solving
            $challengeSolve = $this->challengeSolvingManager->getChallengeInProgress($team);

            // checking that a challenge is in progress for the team
            if (null === $challengeSolve) {
                throw new \Exception("No challenge in progress...");
            }

            // changing the state and the end date
            $challengeSolve
                ->setDateEnd(new \DateTime())
                ->setState(true)
            ;
            $this->challengeSolvingManager->update($challengeSolve);

            // updating the score for the team
            $team->incrementScore($challenge->getPoints());
            $this->teamManager->update($team);

            // everything ok, returning true
            return true;
        }

        // the solution is not correct, returning false
        return false;
    }

    /**
     * Remove a player from his team
     *
     * @param Player $player
     */
    public function leaveTeam(Player $player)
    {
        // setting null to the team
        $player->setTeam(null);

        // updating
        $this->update($player);
    }

    /**
     * @param ChallengeSolvingManager $challengeSolvingManager
     */
    public function setChallengeSolvingManager($challengeSolvingManager)
    {
        $this->challengeSolvingManager = $challengeSolvingManager;
    }

    /**
     * @param TeamManager $teamManager
     */
    public function setTeamManager($teamManager)
    {
        $this->teamManager = $teamManager;
    }
}