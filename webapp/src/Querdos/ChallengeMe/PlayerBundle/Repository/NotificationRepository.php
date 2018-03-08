<?php
/**
 * Created by Hamza ESSAYEGH
 * User: querdos
 * Date: 3/22/17
 * Time: 6:00 PM
 */

namespace Querdos\ChallengeMe\PlayerBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Querdos\ChallengeMe\PlayerBundle\Entity\Notification;
use Querdos\ChallengeMe\UserBundle\Entity\Player;

class NotificationRepository extends EntityRepository
{
    /**
     * Read notifications for the given players
     *
     * @param Player $player
     *
     * @return Notification[]
     */
    public function readForPlayer(Player $player)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('notification')
            ->from('PlayerBundle:Notification', 'notification')

            ->join('notification.player', 'player')
            ->where('player = :player')

            ->setParameter('player', $player)
        ;

        return $query
            ->getQuery()
            ->getResult()
        ;
    }

    public function getUnreadForPlayer(Player $player)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('notification')
            ->from('PlayerBundle:Notification', 'notification')

            ->join('notification.player', 'player')
            ->where('player = :player')
            ->andWhere('notification.state = 0')

            ->setParameter('player', $player)
        ;

        return $query
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return the count of unread notifications for the given player
     *
     * @param Player $player
     *
     * @return int
     */
    public function getUnreadCountForPlayer(Player $player)
    {
        $query = $this
            ->getEntityManager()
            ->createQueryBuilder()

            ->select('COUNT(notification)')
            ->from('PlayerBundle:Notification', 'notification')

            ->join('notification.player', 'player')
            ->where('player = :player')
            ->andWhere('notification.state = 0')

            ->setParameter('player', $player)
        ;

        return $query
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}