<?php
/**
 * Created by Hamza ESSAYEGH.
 * User: querdos
 * Date: 23/02/17
 * Time: 19:50
 */

namespace Querdos\ChallengeMe\UserBundle\Manager;


use Doctrine\ORM\EntityManager;
use Querdos\ChallengeMe\UserBundle\Entity\Administrator;
use Querdos\ChallengeMe\UserBundle\Entity\PrivateMessage;
use Querdos\ChallengeMe\UserBundle\Repository\PrivateMessageRepository;

class PrivateMessageManager
{
    /**
     * @var PrivateMessageRepository $repository
     */
    private $repository;

    /**
     * @var AdministratorManager $adminManager
     */
    private $adminManager;

    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * Create a new private message in database
     *
     * @param PrivateMessage $privateMessage
     */
    public function create(PrivateMessage $privateMessage)
    {
        $this->entityManager->persist($privateMessage);
        $this->entityManager->flush($privateMessage);
    }

    /**
     * Update a private message
     *
     * @param PrivateMessage $privateMessage
     */
    public function update(PrivateMessage $privateMessage)
    {
        // Retrieving unit of work
        $unitOfWork = $this->entityManager->getUnitOfWork();

        // Checking if already persisted
        if (!$unitOfWork->isEntityScheduled($privateMessage)) {
            $this->entityManager->persist($privateMessage);
        }

        // Flushing
        $this->entityManager->flush($privateMessage);
    }

    /**
     * Remove a private message from database
     *
     * @param PrivateMessage $privateMessage
     */
    public function delete(PrivateMessage $privateMessage)
    {
        $this->entityManager->remove($privateMessage);
        $this->entityManager->flush($privateMessage);
    }

    /**
     * Retrieve all private messages with a given author
     *
     * @param Administrator $author
     * @return PrivateMessage[]
     */
    public function readByAuthor(Administrator $author)
    {
        return $this->repository->getByAuthor($author);
    }

    /**
     * Retrieve all private messages with a given recipient
     *
     * @param   Administrator $recipient
     * @return  PrivateMessage[]
     */
    public function readByRecipient(Administrator $recipient)
    {
        return $this->repository->getByRecipient($recipient);
    }
    /**
     * @param PrivateMessageRepository $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AdministratorManager $adminManager
     */
    public function setAdminManager($adminManager)
    {
        $this->adminManager = $adminManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }
}