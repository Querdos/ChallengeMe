<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/9/17
 * Time: 1:53 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Querdos\ChallengeMe\PlayerBundle\Entity\Notification;
use Querdos\ChallengeMe\PlayerBundle\Entity\PlayerActivity;
use Querdos\ChallengeMe\PlayerBundle\Entity\TeamActivity;
use Querdos\ChallengeMe\PlayerBundle\Manager\NotificationManager;
use Querdos\ChallengeMe\PlayerBundle\Manager\PlayerActivityManager;
use Querdos\ChallengeMe\PlayerBundle\Manager\TeamActivityManager;
use Querdos\ChallengeMe\UserBundle\Entity\Player;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class TeamManager extends BaseManager
{
    /**
     * @var NotificationManager
     */
    private $notificationManager;

    /**
     * @var PlayerActivityManager
     */
    private $playerActivityManager;

    /**
     * @var TeamActivityManager
     */
    private $teamActivityManager;

    /**
     * Create a team in database
     *
     * @param Team $team
     */
    public function create($team)
    {
        // adding the leader to the team
        $team
            ->getLeader()
            ->setTeam($team)
        ;

        // persisting the team
        parent::create($team);

        // persisting the leader
        $this->entityManager->persist($team->getLeader());
        $this->entityManager->flush($team->getLeader());

        // sending a notification for the leader
        // TODO @querdos: Manage translation for the team creation (notification)
        $this->notificationManager->create(
            new Notification(
                "Your team has been successfully created",
                $team->getLeader()
            )
        );

        // adding the created team to the player's activity
        $this->playerActivityManager->create(
            new PlayerActivity(
                "Team creation",
                "You have created your team: " . $team->getName(),
                $team->getLeader()
            )
        );
    }

    /**
     * Return the count of all existing teams in database
     *
     * @return int
     */
    public function count()
    {
        return $this->repository->count();
    }

    /**
     * Get the ranking for the given team
     *
     * @param Team $team
     *
     * @return int
     */
    public function getTeamRank(Team $team)
    {
        return $this->repository->teamRank($team);
    }

    /**
     * Promote a player to the leader rank
     *
     * @param Player $player
     */
    public function promote(Player $player)
    {
        // retrieving the team and the leader
        $team = $player->getTeam();
        $leader = $team->getLeader();

        // setting the new leader and updating
        $team->setLeader($player);
        $this->update($team);

        // sending notification to the new leader
        $this->notificationManager->create(
            new Notification(
                "You have been promoted as a leader of your team",
                $player
            )
        );

        // sending notification to the old leader
        $this->notificationManager->create(
            new Notification(
                "The promotion is effective, you are no longer the leader of your team",
                $leader
            )
        );

        // adding activity for the team
        $this->teamActivityManager->create(
            new TeamActivity(
                "New leader",
                $team->getLeader()->getUsername() . " has been promoted as the leader of the team.",
                $team
            )
        );
    }

    /**
     * Return all teams ordered by their rank
     *
     * @param int|null $limit
     *
     * @return Team[]
     */
    public function getTeamsRanked($limit = null)
    {
        return $this->repository->allRanked($limit);
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

    /**
     * @param NotificationManager $notificationManager
     */
    public function setNotificationManager($notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param PlayerActivity $playerActivityManager
     *
     * @return TeamManager
     */
    public function setPlayerActivityManager($playerActivityManager)
    {
        $this->playerActivityManager = $playerActivityManager;
        return $this;
    }

    /**
     * @param TeamActivityManager $teamActivityManager
     *
     * @return TeamManager
     */
    public function setTeamActivityManager($teamActivityManager)
    {
        $this->teamActivityManager = $teamActivityManager;
        return $this;
    }
}