<?php
/**
 * Created by Hamza ESSAYEGH
 * User: Querdos
 * Date: 3/9/17
 * Time: 1:53 PM
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;

use Querdos\ChallengeMe\PlayerBundle\Entity\Notification;
use Querdos\ChallengeMe\PlayerBundle\Manager\NotificationManager;
use Querdos\ChallengeMe\UserBundle\Entity\Team;

class TeamManager extends BaseManager
{
    /**
     * @var NotificationManager $notificationManager
     */
    private $notificationManager;

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
     * Return all teams ordered by their rank
     *
     * @return Team[]
     */
    public function getTeamsRanked()
    {
        return $this->repository->allRanked();
    }

    /**
     * @param NotificationManager $notificationManager
     */
    public function setNotificationManager($notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }
}